{!! Form::model($menu, ['method' => 'PATCH', 'action' => ['MenuController@update', $menu->id]]) !!}
    <div class="box box-primary">
        <div class="box-header with-border">
            <h4 class="box-title pull-left">{!! Form::label('name', trans('strings.LABEL_FOR_MENU_NAME'))!!}:</h4>
            <div class="box-tools">
                <div class="has-feedback">
                    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => trans('strings.LABEL_FOR_MENU_NAME')]) !!}
                </div>
            </div>
            {!! Form::submit(trans('strings.LABEL_FOR_SAVE_MENU_BTN'), ['class' => 'btn btn-primary pull-right', 'id' => 'btn-save-menu']) !!}
                    <!-- /.box-tools -->
        </div>
        <div class="box-body">
            @include('menu.partials.nestedList')
        </div>
        <div class="box-footer">
            <div class="box-tools">
                {{--{!! Form::submit(trans('strings.LABEL_FOR_CREATE_MENU_BTN'), ['class' => 'btn btn-primary pull-right']) !!}--}}
            </div>
        </div>
    </div>
{!! Form::close() !!}