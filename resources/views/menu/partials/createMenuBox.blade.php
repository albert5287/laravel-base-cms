<div class="box box-primary">
    {!! Form::model($menu = new \App\Menu, ['url' => 'menu']) !!}
    <div class="box-header with-border">
        <h4 class="box-title pull-left">{!! Form::label('name', trans('strings.LABEL_FOR_MENU_NAME'))!!}:</h4>
        <div class="box-tools">
            <div class="has-feedback">
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.LABEL_FOR_MENU_NAME')]) !!}
            </div>
        </div>
        {!! Form::submit(trans('strings.LABEL_FOR_CREATE_MENU_BTN'), ['class' => 'btn btn-primary pull-right']) !!}
                <!-- /.box-tools -->
    </div>
    <div class="box-body">
        <p class="post-body-plain">Give your menu a name above, then click Create Menu.</p>
    </div>
    <div class="box-footer">
        <div class="box-tools">
            {!! Form::submit(trans('strings.LABEL_FOR_CREATE_MENU_BTN'), ['class' => 'btn btn-primary pull-right']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>