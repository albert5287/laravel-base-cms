<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Media;
use App\Module;
use App\News;
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

        $new = new News();
        $this->insertUpdateNew($new, $request);

        flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_MODULE'));

        return redirect('news');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param News $new
     * @return Response
     */
    public function edit(News $new)
    {
        $this->setReturnUrl();

        $page_title = trans('strings.TITLE_EDIT_NEWS_PAGE');
        return view('news.edit', compact('new', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  News $new
     * @param NewsRequest $request
     * @return Response
     */
    public function update(News $new, NewsRequest $request)
    {
        $this->insertUpdateNew($new, $request);

        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_LANGUAGE'));

        return $this->redirectPreviousUrl('modules');
    }

    /**
     * function to insert or update a new news
     * @param News $new
     * @param NewsRequest $request
     */
    private function insertUpdateNew(News $new, NewsRequest $request){
        $data = $request->all();
        $new->module_application_id = 1; //TODO: get this dinamically
        insertUpdateMultiLanguage($new, $data);
        $new->syncMedia($data['_relatedMedia']);
    }
}
