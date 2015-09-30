<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModuleRequest;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ModuleController extends BaseController
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

        $class_name = 'Module';

        $module = Module::where('class', $class_name)->first();

        $page_title = $module->title;

        $header_table = ['name' => trans('strings.HEADER_TABLE_FOR_NAME_IN_MODULE'),
            'enabled' => trans('strings.HEADER_TABLE_FOR_ENABLED_IN_MODULE')];

        return $this->setupIndexTable($page_title, $class_name, $header_table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title = trans('strings.TITLE_CREATE_MODULE_PAGE');

        return view('module.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ModuleRequest $request)
    {
        $module = new Module();
        insertUpdateMultiLanguage($module, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_MODULE'));

        return redirect('modules');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Module $module
     * @return Response
     */
    public function edit(Module $module)
    {
        $this->setReturnUrl();

        $page_title = trans('strings.TITLE_EDIT_MODULE_PAGE');
        return view('module.edit', compact('module', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Module $module
     * @return Response
     */
    public function update(Module $module, ModuleRequest $request)
    {
        insertUpdateMultiLanguage($module, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_LANGUAGE'));

        return $this->redirectPreviousUrl('modules');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Module $module
     * @return Response
     */
    public function destroy(Module $module)
    {
        $this->setReturnUrl();

        $module->delete();

        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_MODULE'));

        return $this->redirectPreviousUrl('modules');
    }
}
