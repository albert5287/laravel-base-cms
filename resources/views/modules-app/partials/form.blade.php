<div class="box box-primary">
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @foreach(getActiveLanguages() as $index => $lang)
                    <li {{$index == 0 ? "class=active" : ''}}>
                        <a href="#tab_{{$lang->code}}" data-toggle="tab">{{$lang->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(getActiveLanguages() as $index => $lang)
                    <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="tab_{{$lang->code}}">
                        <div class="form-group">
                            {!! Form::label('name['.$lang->code.']', trans('strings.LABEL_FOR_TITLE_MODULES_APPLICATION_FORM').' '. $lang->name.':') !!}
                            {!! Form::text('name['.$lang->code.']', isset($module->translate($lang->code)->name) ? $module->translate($lang->code)->name : null, ['class' => 'form-control']) !!}
                        </div>
                    </div><!-- /.tab-pane -->
                @endforeach
                <div class="form-group">
                    {!! Form::label('module_id', trans('strings.LABEL_FOR_MODULE_TYPE_MODULES_APPLICATION_FORM').':') !!}
                    {!! Form::select('module_id', $modules, null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div><!-- /.box -->

@section('scripts')
    @include('partials.formScripts')
@stop