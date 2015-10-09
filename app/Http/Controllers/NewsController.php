<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Media;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NewsController extends BaseController
{

    public $module_id = 1;
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

        $class_name = 'News';

        $module = Module::where('class', $class_name)->first();

        $page_title = $module->title;

        $header_table = ['title' => trans('strings.HEADER_TABLE_FOR_NAME_IN_LANGUAGES'),
            'subtitle' => trans('strings.HEADER_TABLE_FOR_CODE_IN_LANGUAGES')];

        return $this->setupIndexTable($page_title, $class_name, $header_table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title = trans('strings.TITLE_CREATE_LANGUAGE_PAGE');

        //dd(Media::AllByApp()->get());

        return view('news.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @return Response
     */
    public function store(NewsRequest $request)
    {
        dd($request->all());
        $new = new News();
        insertUpdateMultiLanguage($new, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_MODULE'));

        return redirect('modules');
    }
}
