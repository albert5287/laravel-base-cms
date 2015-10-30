<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use App\Language;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class LanguageController extends BaseController
{
    protected $className = 'Language';
    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct(){
        $this->module = $this->getModule();
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $pageTitle = $this->module->title;

        $headerTable = ['name' => trans('strings.HEADER_TABLE_FOR_NAME_IN_LANGUAGES'),
                        'code' => trans('strings.HEADER_TABLE_FOR_CODE_IN_LANGUAGES')];

        return $this->setupTable($pageTitle, $headerTable);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $pageTitle = trans('strings.TITLE_CREATE_LANGUAGE_PAGE');

        return view('language.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(LanguageRequest $request)
    {
        $language = new Language();
        insertUpdateMultiLanguage($language, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_LANGUAGE'));

        return redirect('languages');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Language $language
     * @return Response
     */
    public function edit(Language $language)
    {
        $this->setReturnUrl();

        $pageTitle = trans('strings.TITLE_EDIT_LANGUAGE_PAGE');
        return view('language.edit', compact('language', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Language $language
     * @return Response
     */
    public function update(Language $language, LanguageRequest $request)
    {
        insertUpdateMultiLanguage($language, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_LANGUAGE'));

        return $this->redirectPreviousUrl('languages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Language $language
     * @return Response
     */
    public function destroy(Language $language)
    {
        $this->setReturnUrl();

        $language->delete();

        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_LANGUAGE'));

        return $this->redirectPreviousUrl('languages');
    }

}
