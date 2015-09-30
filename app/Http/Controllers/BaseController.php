<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * function to setup the index table of an element in the cms
     * @param $page_title
     * @param $class_name
     * @param $header_table
     * @param string $defaultSort
     * @param string $defaultOrder
     * @param bool|true $addButton
     * @param bool|true $editButton
     * @param bool|false $exportButton
     * @param bool|true $defaultElements
     * @param null $customQuery
     * @return \Illuminate\View\View
     */
    protected function setupIndexTable($page_title, $class_name, $header_table, $defaultSort = 'id', $defaultOrder = 'asc', $addButton = true, $editButton = true, $exportButton = false, $defaultElements = true, $customQuery = null){
        //allowed columns for the sorting
        $allowedColumns = array_keys($header_table);
        //get sorting
        $sort = in_array(Input::get('sort'), $allowedColumns) ? Input::get('sort') : $defaultSort;
        //get order
        $order = Input::get('order') === null ? $defaultOrder : Input::get('order');
        //get search
        $search = Input::get('search') !== null ? Input::get('search') : '';

        if($defaultElements){
            $elements = $this->getDefaultElements($class_name, $sort, $order, $search, $allowedColumns);
        }
        else{
            $elements = $customQuery->orderBy($sort, $order)
                ->paginate(PAGINATION);
        }
        return view('partials.table.index', compact('elements', 'page_title', 'header_table', 'class_name', 'sort', 'order','search', 'addButton', 'editButton', 'exportButton'));
    }

    /**
     * function to export data into an excel file
     * @param string $fileName
     * @param array $elementsArray
     * @param string $exportType
     */
    protected function exportData($fileName = 'file', $elementsArray = array(), $exportType = 'csv'){
        Excel::create($fileName, function($excel) use ($elementsArray) {

            $excel->sheet('Sheetname', function($sheet) use ($elementsArray) {
                $sheet->fromArray($elementsArray);

            });

        })->export($exportType);

    }

    /**
     *function that saves in session the return url for an action
     */
    protected function setReturnUrl(){
        Session::put('returnUrl',URL::previous());
    }

    /**
     * function that redirects to the previous url (if exists) before execute an action
     * if not exists redirects to the page given
     * @param $url
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function redirectPreviousUrl($url){
        if(Session::has('returnUrl')){
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
     * @return mixed
     */
    private function getDefaultElements($className, $sort, $order, $search, $allowedColumns)
    {
        $className = "App\\".$className;
        $model = new $className;
        $elements = $model->orderBy($sort, $order);
        if($search !== ''){
            foreach($allowedColumns as $column){
                $elements->orWhere($column, 'like', '%'.$search.'%');
            }
        }
        return $elements->paginate(PAGINATION);
    }

}
