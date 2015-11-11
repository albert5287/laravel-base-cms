<?php namespace App\Http\Controllers;

use App\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use yajra\Datatables\Facades\Datatables;

abstract class BaseController extends Controller
{
    /**
     * The Module type.
     */
    protected $module = null;
    /**
     * Variable to show add button in the view
     * true by default.
     */
    protected $addButton = true;
    /**
     * Variable to show edit button in the table
     * true by default.
     */
    protected $editButton = true;
    /**
     * Variable to show delete button in the table
     * true by default.
     */
    protected $deleteButton = true;
    /**
     * Variable to show export button in the table
     * false by default.
     */
    protected $exportButton = false;
    /**
     * variable to set and additional parameter
     * to be sent on the edit button
     */
    protected $customUrlEditParameters = null;
    /**
     * variable to set and additional parameter
     * to be sent on the delete button
     */
    protected $customUrlDeleteParameters = null;

    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct()
    {
        $this->module = $this->getModule();
        //if there is a user and is not admin and not super admin I check the users permissions
        if (Auth::check() && !(Auth::user()->is('super.admin') || Auth::user()->is(Session::get('currentApp')->id . '.admin'))) {
            $this->middleware('permission:show.' . Session::get('currentApp')->id . '.' . strtolower($this->className));
            $this->middleware('permission:edit.' . Session::get('currentApp')->id . '.' . strtolower($this->className),
                ['only' => ['update']]);
            $this->middleware('permission:create.' . Session::get('currentApp')->id . '.' . strtolower($this->className),
                ['only' => ['store']]);
            $this->middleware('permission:delete.' . Session::get('currentApp')->id . '.' . strtolower($this->className),
                ['only' => ['destroy']]);
        }
    }


    /**
     * function to set up the table
     * @param string $pageTitle
     * @param null $headerTable
     * @param int $module_application_id
     * @param string $view
     * @param null $application
     * @return \BladeView|bool|\Illuminate\View\View
     */
    protected function setupTable(
        $pageTitle = '',
        $headerTable = null,
        $module_application_id = 0,
        $view = 'partials.table.index',
        $application = null
    ) {
        //get sorting
        $sort = Input::get('sort') === null ? false : Input::get('sort');
        //get order
        $order = Input::get('order') === null ? false : Input::get('order');
        //get search
        $search = Input::get('search');
        //get page
        $page = Input::get('page') === null ? 0 : Input::get('order');;

        $class_name = $this->className;

        return view($view,
            compact('pageTitle', 'headerTable', 'class_name', 'module_application_id', 'sort', 'order', 'page',
                'search', 'application'));
    }

    /**
     * function to export data into an excel file
     * @param string $fileName
     * @param array $elementsArray
     * @param string $exportType
     */
    protected function exportData($fileName = 'file', $elementsArray = array(), $exportType = 'csv')
    {
        Excel::create($fileName, function ($excel) use ($elementsArray) {

            $excel->sheet('Sheetname', function ($sheet) use ($elementsArray) {
                $sheet->fromArray($elementsArray);

            });

        })->export($exportType);

    }

    /**
     *function that saves in session the return url for an action
     */
    protected function setReturnUrl()
    {
        Session::put('returnUrl', URL::previous());
    }

    /**
     * function that redirects to the previous url (if exists) before execute an action
     * if not exists redirects to the page given
     * @param $url
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectPreviousUrl($url = 'home')
    {
        if (Session::has('returnUrl')) {
            $url = Session::pull('returnUrl', 'default');
        }
        return redirect($url);
    }

    /**
     * function to get the elements from a model
     * @param $module_application_id
     * @return mixed
     */
    private function getElements($module_application_id = 0)
    {
        //if the method getCustomCollection exist then there is a custom collection
        if (method_exists($this, 'getCustomCollection')) {
            $elements = $this->getCustomCollection();
        } //if not then i get the default elements
        else {
            $className = "App\\" . $this->className;
            $model = new $className;
            $elements = $model;
            if ($module_application_id > 0) {
                $elements = $elements->where('module_application_id', '=', $module_application_id);
            }
            //if the model use use translations the i get the translations
            if (!empty($usedTraits = class_uses($model)) && isset($usedTraits['Dimsav\Translatable\Translatable'])) {
                $elements = $elements->withTranslation();
            }
            $elements = $elements->get();
        }
        return $elements;
    }

    /**
     * function to get the module
     * @return mixed
     */
    protected function getModule()
    {
        return Module::where('class', $this->className)->first();
    }

    /**
     * function to get the data for the datatable
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($module_application_id = 0)
    {
        $elements = $this->getElements($module_application_id);

        return Datatables::of($elements)
            ->addColumn('action', function ($elements) use ($module_application_id) {
                $editButton = $this->editButton($elements, $module_application_id);
                $deleteButton = $this->deleteButton($elements);
                return $editButton . $deleteButton;
            })->make(true);
    }

    /**
     * function to create the delete button
     * @param $element
     * @return string
     */
    private function deleteButton($element)
    {
        $deleteButton = '';
        if (checkIfUserIsValidForDeleteButton($this->className)) {
            if ($this->deleteButton) {
                $urlParams = [$element->id];
                $urlParams = $this->customUrlDeleteParameters === null ? $urlParams : array_merge($urlParams,
                    $this->customUrlDeleteParameters);
                $url = action($this->className . 'Controller@destroy', $urlParams);
                $deleteButton = '<form method="POST" action="' . $url . '" accept-charset="UTF-8" id="deleteForm_' . $element->id . '">
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input name="_token" type="hidden" value="' . csrf_token() . '">
                                    <button type="button" class="btn btn-danger qs" data-toggle="modal" data-target="#modal"
                                        data-title="L&ouml;schen?" data-body="M&ouml;chten Sie den Eintrag wirklich l&ouml;schen?"
                                        data-btnconfirm="L&ouml;schen" data-form="deleteForm_' . $element->id . '"
                                        data-elementid="' . $element->id . '">
                                        <i class="fa fa-trash"></i><span class="popover above">l&ouml;schen</span>
                                    </button>
                                </form>';
            }
        }
        return $deleteButton;

    }

    /**
     * function to create the edi button
     * @param $elements
     * @return string
     */
    private function editButton($elements, $module_application_id = 0)
    {
        $editButton = '';
        if (checkIfUserHavePermissions('edit', $this->className)) {
            if ($this->editButton) {
                $urlParams = [$elements->id];
                if ($this->customUrlEditParameters === null) {
                    if ($module_application_id !== 0) {
                        $urlParams[] = $this->module;
                    }
                } else {
                    $urlParams = array_merge($urlParams, $this->customUrlEditParameters);
                }
                $url = action($this->className . 'Controller@edit', $urlParams);
                $editButton = '<a href="' . $url . '" class="btn btn-info pull-left qs" style="margin-right: 3px;">
                                <i class="fa fa-edit"></i>
                                <span class="popover above">bearbeiten</span>
                            </a>';
            }
        }
        return $editButton;
    }

}
