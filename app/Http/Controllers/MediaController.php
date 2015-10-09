<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $uploadedFiles = [];
        if(isset($data['file']) && sizeof($data['file']) > 0){
            //$uploadedFiles = Media::uploadAndSaveFiles($data['file']);
        }
        return $uploadedFiles;

    }

}
