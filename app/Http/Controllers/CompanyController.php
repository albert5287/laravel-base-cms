<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use App\Module;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CompanyController extends BaseController
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

        $class_name = 'Company';

        $module = Module::where('class', $class_name)->first();

        $page_title = $module->title;

        $header_table = ['name' => trans('strings.HEADER_TABLE_FOR_NAME_IN_COMPANIES'),
            'email' => trans('strings.HEADER_TABLE_FOR_EMAIL_IN_COMPANIES')];

        return $this->setupIndexTable($page_title, $class_name, $header_table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $page_title = trans('strings.TITLE_CREATE_COMPANY_PAGE');

        return view('company.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     * @return Response
     */
    public function store(CompanyRequest $request)
    {
        $company = new Company();
        insertUpdateMultiLanguage($company, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_CREATE_COMPANY'));

        return redirect('companies');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return Response
     */
    public function edit(Company $company)
    {
        $this->setReturnUrl();

        $page_title = trans('strings.TITLE_EDIT_COMPANY_PAGE');
        return view('company.edit', compact('company', 'page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Company $company
     * @param CompanyRequest $request
     * @return Response
     */
    public function update(Company $company, CompanyRequest $request)
    {
        insertUpdateMultiLanguage($company, $request->all());

        flash()->success(trans('strings.MESSAGE_SUCCESS_EDIT_COMPANY'));

        return $this->redirectPreviousUrl('companies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Company $company
     * @return Response
     */
    public function destroy(Company $company)
    {
        $this->setReturnUrl();

        $company->delete();

        flash()->success(trans('strings.MESSAGE_SUCCESS_DELETE_COMPANY'));

        return $this->redirectPreviousUrl('companies');
    }
}
