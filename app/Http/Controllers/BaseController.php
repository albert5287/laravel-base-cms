<?php namespace App\Http\Controllers;

use App\Module;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use yajra\Datatables\Facades\Datatables;

class BaseController extends Controller
{

    protected function setupTable(
        $pageTitle = '',
        $headerTable = null,
        $module_application_id = 0,
        $view = 'partials.table.index'
    ) {
        //dd(Input::get());

        //allowed columns for the sorting
        $allowedColumns = array_keys($headerTable);
        //get sorting
        $sort = Input::get('sort') === NULL ? false : Input::get('sort');
        //get order
        $order = Input::get('order') === NULL ? false : Input::get('order');
        //get search
        $search = Input::get('search');
        //get page
        $page = Input::get('page') === NULL ? 0 : Input::get('order');;

        $class_name = $this->className;

        return view('partials.table.index',
            compact('pageTitle', 'headerTable', 'class_name', 'module_application_id', 'sort', 'order', 'page',
                'search'));
    }


    /**
     * function to setup the index table of an element in the cms
     * @param $page_title
     * @param $class_name
     * @param $header_table
     * @param null $adittionalQueryConditions
     * @param string $defaultSort
     * @param string $defaultOrder
     * @param bool|true $addButton
     * @param bool|true $editButton
     * @param bool|false $exportButton
     * @param bool|true $defaultElements
     * @param null $customQuery
     * @return \Illuminate\View\View
     */
    protected function setupIndexTable(
        $page_title,
        $class_name,
        $header_table,
        $adittionalQueryConditions = null,
        $defaultSort = 'id',
        $defaultOrder = 'asc',
        $addButton = true,
        $editButton = true,
        $exportButton = false,
        $defaultElements = true,
        $customQuery = null
    ) {

        $tableElements = $this->setupTable($class_name, $header_table, $adittionalQueryConditions, $defaultSort,
            $defaultOrder, $defaultElements, $customQuery);
        list($elements, $sort, $order, $search) = $tableElements;

        return view('partials.table.index',
            compact('elements', 'page_title', 'header_table', 'class_name', 'sort', 'order', 'search', 'addButton',
                'editButton', 'exportButton'));
    }

    /**
     * @param $page_title
     * @param $class_name
     * @param $header_table
     * @param null $adittionalQueryConditions
     * @param null $module
     * @param string $defaultSort
     * @param string $defaultOrder
     * @param bool|true $addButton
     * @param bool|true $editButton
     * @param bool|false $exportButton
     * @param bool|true $defaultElements
     * @param null $customQuery
     * @return \Illuminate\View\View
     */
    protected function setupContentModuleIndex(
        $page_title,
        $class_name,
        $header_table,
        $adittionalQueryConditions = null,
        $module = null,
        $defaultSort = 'id',
        $defaultOrder = 'asc',
        $addButton = true,
        $editButton = true,
        $exportButton = false,
        $defaultElements = true,
        $customQuery = null
    ) {
        $tableElements = $this->setupTable($class_name, $header_table, $adittionalQueryConditions, $defaultSort,
            $defaultOrder, $defaultElements, $customQuery);
        list($elements, $sort, $order, $search) = $tableElements;
        return view('partials.contentModule.index',
            compact('elements', 'page_title', 'header_table', 'class_name', 'sort', 'order', 'search', 'addButton',
                'editButton', 'exportButton', 'module'));
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
    protected function redirectPreviousUrl($url)
    {
        if (Session::has('returnUrl')) {
            $url = Session::pull('returnUrl', 'default');
        }
        return redirect($url);
    }

    /**
     * function to get the default elements from a model
     * @param $className
     * @param $sort
     * @param $order
     * @param $search
     * @param $allowedColumns
     * @param $adittionalQueryConditions
     * @return mixed
     */
    private function getDefaultElements($className, $sort, $order, $search, $allowedColumns, $adittionalQueryConditions)
    {
        $className = "App\\" . $className;
        $model = new $className;
        $elements = $model->orderBy($sort, $order);
        if ($adittionalQueryConditions !== null) {
            foreach ($adittionalQueryConditions as $key => $value) {
                $elements->$key($value[0], $value[1], $value[2]);
            }

        }
        if (!empty($usedTraits = class_uses($model)) && isset($usedTraits['Dimsav\Translatable\Translatable'])) {
            $elements->withTranslation();
        }
        if ($search !== '') {
            foreach ($allowedColumns as $column) {
                $elements->orWhere($column, 'like', '%' . $search . '%');
            }
        }
        return $elements->paginate(PAGINATION);
    }

    /**
     * @param $class_name
     * @param $header_table
     * @param $adittionalQueryConditions
     * @param $defaultSort
     * @param $defaultOrder
     * @param $defaultElements
     * @param $customQuery
     * @return array
     */
    private function _setupTable(
        $class_name,
        $header_table,
        $adittionalQueryConditions,
        $defaultSort,
        $defaultOrder,
        $defaultElements,
        $customQuery
    ) {
        //allowed columns for the sorting
        $allowedColumns = array_keys($header_table);
        //get sorting
        $sort = in_array(Input::get('sort'), $allowedColumns) ? Input::get('sort') : $defaultSort;
        //get order
        $order = Input::get('order') === null ? $defaultOrder : Input::get('order');
        //get search
        $search = Input::get('search') !== null ? Input::get('search') : '';

        if ($defaultElements) {
            $elements = $this->getDefaultElements($class_name, $sort, $order, $search, $allowedColumns,
                $adittionalQueryConditions);
        } else {
            $elements = $customQuery->orderBy($sort, $order)
                ->paginate(PAGINATION);
        }
        return [$elements, $sort, $order, $search];
    }

    /**
     * @return mixed
     */
    protected function getModule()
    {
        return Module::where('class', $this->className)->first();
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data($module_application_id = null)
    {
        $className = "App\\" . $this->className;
        $model = new $className;
        $news = $model->withTranslation()->get();
        return Datatables::of($news)
            ->addColumn('action', function ($news) {
                return '<a href="?edit=' . $news->id . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })->make(true);
    }

}
