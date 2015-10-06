<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title pull-left">{!! Form::label('menu_id', trans('strings.LABEL_FOR_SELECT_A_MENU_TO_EDIT'))!!}:</h3>
        <div class="box-tools has-feedback">
            {!! Form::select('menu_id', $menus, isset($menu->id) ? $menu->id : null, ['class' => 'form-control']) !!}
        </div>
        <div class="box-tools has-feedback">
            <input id="select_menu" class="btn btn-primary" type="submit" value="select">
        </div>
        <span class="add-new-menu-action">Or <a href="{{action('MenuController@create')}}">create a new one</a></span>
        <!-- /.box-tools -->
    </div>
</div>