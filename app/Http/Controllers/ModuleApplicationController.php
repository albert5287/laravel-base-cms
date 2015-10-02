<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleApplicationRequest;
use App\Module;
use App\ModuleApplication;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ModuleApplicationController extends BaseController
{
    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $class_name = 'ModuleApplication';

        $module = Module::where('class', $class_name)->first();

        $page_title = $module->title;

        $header_table = ['name' => trans('strings.HEADER_TABLE_FOR_NAME_IN_MODULES_APPLICATION'),
            'moduleType' => trans('strings.HEADER_TABLE_FOR_MODULE_TYPE_IN_MODULES_APPLICATION')];

        return $this->setupIndexTable($page_title, $class_name, $header_table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title = trans('strings.TITLE_CREATE_MODULES_APPLICATION_PAGE');

        $modules = ['' => ''] + Module::all()->lists('title', 'id')->all();

        return view('modules-app.create', compact('page_title', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ModuleApplicationRequest $request
     * @return Response
     */
    public function store(ModuleApplicationRequest $request)
    {
        $moduleApplication = new ModuleApplication();

        insertUpdateMultiLanguage($moduleApplication, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_APPLICATION_MODULE'));

        return redirect('modules-app');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ModuleApplication $module
     * @return Response
     */
    public function edit(ModuleApplication $module)
    {
        $this->setReturnUrl();

        $page_title = trans('strings.TITLE_EDIT_COMPANY_PAGE');

        $modules = ['' => ''] + Module::all()->lists('title', 'id')->all();

        return view('modules-app.edit', compact('module', 'page_title', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ModuleApplication $module
     * @param ModuleApplicationRequest $request
     * @return Response
     */
    public function update(ModuleApplication $module, ModuleApplicationRequest $request)
    {
        insertUpdateMultiLanguage($module, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_APPLICATION_MODULE'));

        return $this->redirectPreviousUrl('modules-app');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ModuleApplication $module
     * @return Response
     */
    public function destroy(ModuleApplication $module)
    {
        $this->setReturnUrl();

        $module->delete();

        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_APPLICATION_MODULE'));

        return $this->redirectPreviousUrl('modules-app');
    }
}
