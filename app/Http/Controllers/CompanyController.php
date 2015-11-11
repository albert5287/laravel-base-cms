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
    protected $className = 'Company';
    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct(){
        parent::__construct();
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

        $headerTable = ['name' => trans('strings.HEADER_TABLE_FOR_NAME_IN_COMPANIES'),
            'email' => trans('strings.HEADER_TABLE_FOR_EMAIL_IN_COMPANIES')];

        return $this->setupTable($pageTitle, $headerTable);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $pageTitle = trans('strings.TITLE_CREATE_COMPANY_PAGE');

        return view('company.create', compact('pageTitle'));
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

        $pageTitle = trans('strings.TITLE_EDIT_COMPANY_PAGE');
        return view('company.edit', compact('company', 'pageTitle'));
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
