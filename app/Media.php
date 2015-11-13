<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class Media extends Model
{
    use Translatable;

    protected $table = 'medias';

    protected $fillable = [
        'media_type_id',
        'url',
        'trash',
        'file_name',
        'application_id'
    ];

    /**
     * Array with the fields translated in the Translation table.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'description'];



    /**
     * queryscope to get all the media elements from an app
     * @param $query
     */
    public function scopeAllByApp($query){
        $query->withTranslation()->where('application_id', '=', getCurrentApp()->id);
    }



    public function getThumbnail(){
        $aux = pathinfo($this->url); //get the file info
        if($this->media_type_id === MEDIA_TYPE_IMAGE){
            if(File::exists($aux['dirname'].'/thumbnail_'.$aux['basename'])){
                return $aux['dirname'].'/thumbnail_'.$aux['basename'];
            }
            else if(File::exists($this->url)){
                return $this->url;
            }
        }
        //TODO: put the images in the folder and uncomment this code
        /*
        else if($this->media_type === 'document'){
            if(in_array($aux['extension'], array('doc', 'docx', 'docm', 'dotx','dotm'))){
                return 'img/doc.png';
            }
            else if(in_array($aux['extension'], array('pot|pps|ppt','pptx','pptm','ppsx','ppsm','potx','potm','ppam'))){
                return 'img/ppt.png';
            }
            else if(in_array($aux['extension'], array('xla|xls|xlt|xlw','xlsx','xlsm','xlsb','xltx','xltm','xlam'))){
                return 'img/xls.png';
            }
            else if(in_array($aux['extension'], array('tar','zip','gz|gzip','rar','7z'))){
                return 'img/zip.png';
            }
            else if(in_array($aux['extension'], array('pdf'))){
                return 'img/pdf.png';
            }
        }
        */
        else{
            return 'img/'.$this->media_type.'.png';
        }
    }


}
