<?php
/**
 * Created by PhpStorm.
 * User: albert.gracia
 * Date: 12.11.2015
 * Time: 15:31
 */

namespace Acme\Repositories;


use App\Media;
use Intervention\Image\Facades\Image;

class MediaRepository extends DbRepository
{
    protected $appId;

    /**
     * @param Media $model
     */
    function __construct(Media $model)
    {
        $this->model = $model;
        $this->appId = getCurrentApp()->id;
    }

    /**
     * get the sizes to treat the images
     * @return array
     */
    public function getImageSizes()
    {
        $sizes = array(
            'thumbnail' => array(150, 150),
            'medium' => array(640, 360),
            'large' => array(900, 600)
        );

        return $sizes;
    }

    /**
     * function that receives an array of files and
     * handle upload the file into the server
     * and create the record in the db
     * @param $files
     * @return array
     */
    public function uploadAndSaveFiles($files, $application_id)
    {
        $path = 'uploads/' . date("Ym") . '/';
        $uploadedFiles = [];
        foreach ($files as $file) {
            if ($file->isValid()) {
                $aux = pathinfo($file->getClientOriginalName()); //get the file info
                $origFileName = str_slug($aux['filename']) . '.' . $aux['extension'];
                $fileName = time() . '_' . $origFileName; //create the name for the file
                $file->move($path, $fileName); //move the file to the uploads folder
                $media = $this->createMedia($origFileName, $path . $fileName, $this->getType($file), $application_id);
                $uploadedFiles[] = $media; //insert the id into the ids array
                if ($this->isImage($file)) {
                    $this->createDifferentSizes($media); //create diferent sizes
                }
            }
        }
        return $uploadedFiles;
    }

    /**
     * @param $filename
     * @param $url
     * @param $type
     * @param $application_id
     * @return Media
     */
    private function createMedia($filename, $url, $type, $application_id)
    {
        return $this->create(
            [
                "application_id" => $application_id,
                "file_name" => $filename, //fill the title
                "url" => $url, //fill the url
                "media_type_id" => $type, //fill the media type
            ]);
    }

    private function createDifferentSizes($media)
    {
        $path = 'uploads/'.date("Ym").'/';
        $sizes = $this->getImageSizes();

        $aux = pathinfo($media->url); //get the file info
        foreach($sizes as $key => $value) {
            $img = Image::make($media->url); //open the image

            //if it is the thumbnail
            if($key === 'thumbnail')
            {
                $img->fit($value[0], $value[1]); //fit the image (crop and resize)
            }
            //otherwise resize mantaining the aspect ratio
            else{
                $img->resize($value[0], $value[1], function ($constraint) {
                    $constraint->aspectRatio();
                });
            }


            $img->save($path .$key.'_'.$aux['filename'].'.'.$aux['extension']);
        }
    }

    public function getType($file)
    {
        if($this->isImage($file)){
            return 1;
        }
        else if($this->isVideo($file)){
            return 'video';
        }
        else if($this->isAudio($file)){
            return 'audio';
        }
        else if($this->isDocument($file)){
            return 'document';
        }
        else{
            return false;
        }
    }

    private function isImage($file)
    {
        $validImagesMimeType = array(
            'jpg|jpeg|jpe'      =>  'image/jpeg',
            'gif'               =>  'image/gif',
            'png'               =>  'image/png',
            'bmp'               =>  'image/bmp',
            'tif|tiff'          =>  'image/tiff',
            'ico'               =>  'image/x-icon'
        );

        //if the MimeType is  'application/octet-stream'
        //then i check the file by extension
        if($file->getClientMimeType() == 'application/octet-stream'){
            return in_array($file->getClientOriginalExtension(), array_keys($validImagesMimeType));
        }
        //else i check it by the mime type
        else{
            return in_array($file->getClientMimeType(), $validImagesMimeType);
        }
    }

    private function isVideo($file)
    {
        $validMimeType = array(
            'asf|asx'                      => 'video/x-ms-asf',
            'wmv'                          => 'video/x-ms-wmv',
            'wmx'                          => 'video/x-ms-wmx',
            'wm'                           => 'video/x-ms-wm',
            'avi'                          => 'video/avi',
            'divx'                         => 'video/divx',
            'flv'                          => 'video/x-flv',
            'mov|qt'                       => 'video/quicktime',
            'mpeg|mpg|mpe'                 => 'video/mpeg',
            'mp4|m4v'                      => 'video/mp4',
            'ogv'                          => 'video/ogg',
            'webm'                         => 'video/webm',
            'mkv'                          => 'video/x-matroska',
        );

        //if the MimeType is  'application/octet-stream'
        //then i check the file by extension
        if($file->getClientMimeType() == 'application/octet-stream'){
            return in_array($file->getClientOriginalExtension(), array_keys($validMimeType));
        }
        //else i check it by the mime type
        else{
            return in_array($file->getClientMimeType(), $validMimeType);
        }
    }

    private function isAudio($file)
    {
        $validMimeType = array(
            'mp3|m4a|m4b'                  => 'audio/mpeg',
            'ra|ram'                       => 'audio/x-realaudio',
            'wav'                          => 'audio/wav',
            'ogg|oga'                      => 'audio/ogg',
            'mid|midi'                     => 'audio/midi',
            'wma'                          => 'audio/x-ms-wma',
            'wax'                          => 'audio/x-ms-wax',
            'mka'                          => 'audio/x-matroska',
        );

        //fi the MimeType is  'application/octet-stream'
        //then i check the file by extension
        if($file->getClientMimeType() == 'application/octet-stream' || $file->getClientMimeType() == 'audio/mp3'){
            return sizeof(preg_grep ('/^'.$file->getClientOriginalExtension().'/i', array_keys($validMimeType))) > 0;
        }
        //else i check it by the mime type
        else{
            return in_array($file->getClientMimeType(), $validMimeType);
        }
    }

    private function isDocument($file)
    {
        $validMimeType = array(
            // Text formats
            'txt|asc|c|cc|h'               => 'text/plain',
            'csv'                          => 'text/csv',
            'tsv'                          => 'text/tab-separated-values',
            'ics'                          => 'text/calendar',
            'rtx'                          => 'text/richtext',
            'css'                          => 'text/css',
            'htm|html'                     => 'text/html',
            // Misc application formats
            'rtf'                          => 'application/rtf',
            'js'                           => 'application/javascript',
            'pdf'                          => 'application/pdf',
            'swf'                          => 'application/x-shockwave-flash',
            'class'                        => 'application/java',
            'tar'                          => 'application/x-tar',
            'zip'                          => 'application/zip',
            'gz|gzip'                      => 'application/x-gzip',
            'rar'                          => 'application/rar',
            '7z'                           => 'application/x-7z-compressed',
            'exe'                          => 'application/x-msdownload',
            // MS Office formats
            'doc'                          => 'application/msword',
            'pot|pps|ppt'                  => 'application/vnd.ms-powerpoint',
            'wri'                          => 'application/vnd.ms-write',
            'xla|xls|xlt|xlw'              => 'application/vnd.ms-excel',
            'mdb'                          => 'application/vnd.ms-access',
            'mpp'                          => 'application/vnd.ms-project',
            'docx'                         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'docm'                         => 'application/vnd.ms-word.document.macroEnabled.12',
            'dotx'                         => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'dotm'                         => 'application/vnd.ms-word.template.macroEnabled.12',
            'xlsx'                         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xlsm'                         => 'application/vnd.ms-excel.sheet.macroEnabled.12',
            'xlsb'                         => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'xltx'                         => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'xltm'                         => 'application/vnd.ms-excel.template.macroEnabled.12',
            'xlam'                         => 'application/vnd.ms-excel.addin.macroEnabled.12',
            'pptx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'pptm'                         => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
            'ppsx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'ppsm'                         => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
            'potx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'potm'                         => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
            'ppam'                         => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
            'sldx'                         => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
            'sldm'                         => 'application/vnd.ms-powerpoint.slide.macroEnabled.12',
            'onetoc|onetoc2|onetmp|onepkg' => 'application/onenote',

            // OpenOffice formats
            'odt'                          => 'application/vnd.oasis.opendocument.text',
            'odp'                          => 'application/vnd.oasis.opendocument.presentation',
            'ods'                          => 'application/vnd.oasis.opendocument.spreadsheet',
            'o dg'                          => 'application/vnd.oasis.opendocument.graphics',
            'odc'                          => 'application/vnd.oasis.opendocument.chart',
            'odb'                          => 'application/vnd.oasis.opendocument.database',
            'odf'                          => 'application/vnd.oasis.opendocument.formula',

            // WordPerfect formats
            'wp|wpd'                       => 'application/wordperfect',

            // iWork formats
            'key'                          => 'application/vnd.apple.keynote',
            'numbers'                      => 'application/vnd.apple.numbers',
            'pages'                        => 'application/vnd.apple.pages',
        );

        //if the MimeType is  'application/octet-stream'
        //then i check the file by extension
        if($file->getClientMimeType() == 'application/octet-stream'){
            return in_array($file->getClientOriginalExtension(), array_keys($validMimeType));
        }
        //else i check it by the mime type
        else{
            return in_array($file->getClientMimeType(), $validMimeType);
        }
    }
}