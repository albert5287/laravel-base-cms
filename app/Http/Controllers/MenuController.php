<?php

namespace App\Http\Controllers;

use App\Http\Requests\MenuRequest;
use App\Menu;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Constructor.
     *
     * check the authentication for every method in this controller
     */
    public function __construct(){
        $this->middleware('auth');
    }
    public $id_app = 3;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $page_title = trans('strings.TITLE_CREATE_COMPANY_PAGE');
        $menus = Menu::where('application_id', '=', $this->id_app)->lists('name', 'id')->all();
        //if the app has not menu go to create
        if(empty($menus)){
            return view('menu.create', compact('page_title', 'menus'));
        }
        //if it has menu get the enabled one and go to edit
        else{
            $menu = Menu::where('application_id', '=', $this->id_app)->where('enabled', '=', true)->first();
            return redirect()->action('MenuController@edit', [$menu->id]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $menus = Menu::where('application_id', '=', $this->id_app)->lists('name', 'id')->all();
        $page_title = trans('strings.TITLE_CREATE_COMPANY_PAGE');

        return view('menu.create', compact('page_title', 'menus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Menu $menu
     * @return Response
     */
    public function edit(Menu $menu)
    {
        $page_title = trans('strings.TITLE_EDIT_COMPANY_PAGE');
        $menus = Menu::where('application_id', '=', $this->id_app)->lists('name', 'id')->all();
        return view('menu.edit', compact('page_title', 'menus', 'menu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuRequest $request
     * @return Response
     */
    public function store(MenuRequest $request)
    {
        $request = $request->all();
        $menu = new Menu();
        $menu->name = $request['name'];
        $menu->application_id = $this->id_app;
        $menu->save();
        $this->edit($menu);

    }
}
