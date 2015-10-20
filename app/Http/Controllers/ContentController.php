<?php

namespace App\Http\Controllers;

use App\ModuleApplication;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ContentController extends Controller
{
    public function index(){
        $contentModule = ModuleApplication::where('application_id', '=', Session::get('currentApp')->id)->first();
        return redirect($contentModule->moduleType.'/'.$contentModule->id);
    }
}
