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

    protected $className = 'News';


    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->module = $this->getModule();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($module_application_id = 0)
    {
        $pageTitle = $this->module->title;

        $headerTable = [
            'title' => trans('strings.LABEL_FOR_TITLE'),
            'subtitle' => trans('strings.LABEL_FOR_SUBTITLE')
        ];

        return $this->setupTable($pageTitle, $headerTable, $module_application_id, 'partials.contentModule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($module_application_id)
    {
        $this->setReturnUrl();
        $pageTitle = trans('strings.TITLE_CREATE_PAGE_NEWS');

        return view('news.create', compact('pageTitle', 'module_application_id'));
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

        return $this->redirectPreviousUrl('news/' . $new->module_application_id);
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

        $pageTitle = trans('strings.TITLE_EDIT_NEWS_PAGE');
        return view('news.edit', compact('new', 'pageTitle'));
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
    private function insertUpdateNew(News $new, NewsRequest $request)
    {
        $data = $request->all();
        insertUpdateMultiLanguage($new, $data);
        $relatedMedia = isset($data['_relatedMedia']) ? $data['_relatedMedia'] : [];
        $new->syncMedia($relatedMedia);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  News $new
     * @return Response
     */
    public function destroy(News $new)
    {
        $this->setReturnUrl();

        $new->delete();

        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_COMPANY'));

        return $this->redirectPreviousUrl('news');
    }
}
