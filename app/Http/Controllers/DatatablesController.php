<?php

namespace App\Http\Controllers;

use App\Module;
use App\News;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables;
use Illuminate\Support\Facades\Input;

class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('datatables');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data()
    {
        //dd(Input::get('lang'));
        $news = Module::withTranslation()->get();
        //dd($news);
        return Datatables::of($news)
            /*->addColumn('action', function ($news) {
                return '<a href="?edit='.$news->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })*/
            ->make(true);
    }
}
