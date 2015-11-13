<?php

namespace App\Http\Controllers;

use Acme\Repositories\ModuleApplicationRepository;
use App\ModuleApplication;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ContentController extends Controller
{

    protected $moduleApplicationRepository;

    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     * @param ModuleApplicationRepository $moduleApplicationRepository
     */
    public function __construct(ModuleApplicationRepository $moduleApplicationRepository){
        $this->middleware('auth');
        $this->moduleApplicationRepository = $moduleApplicationRepository;
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index(){
        $contentModule = $this->moduleApplicationRepository->getFirstForApp(getCurrentApp()->id);
        return redirect($contentModule->moduleType.'/'.$contentModule->id);
    }
}
