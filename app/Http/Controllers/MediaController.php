<?php

namespace App\Http\Controllers;

use Acme\Repositories\MediaRepository;
use App\Media;
use Illuminate\Http\Request;
use App\Http\Requests;

class MediaController extends Controller
{

    protected $mediaRepository;

    /**
     * @param MediaRepository $mediaRepository
     */
    public function __construct(MediaRepository $mediaRepository){
        $this->middleware('auth');
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $uploadedFiles = [];
        if(isset($data['file']) && sizeof($data['file']) > 0){
            $uploadedFiles = $this->mediaRepository->uploadAndSaveFiles
            (
                $data['file'],
                $data['application_id']
            );
        }
        return $uploadedFiles;
    }

}
