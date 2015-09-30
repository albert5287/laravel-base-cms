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
                <div class="form-group">
                    {!! Form::label('name', trans('strings.LABEL_FOR_NAME_MODULE_FORM').':') !!}
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('class', trans('strings.LABEL_FOR_CLASS_MODULE_FORM').':') !!}
                    {!! Form::text('class', null, ['class' => 'form-control']) !!}
                </div>
                @foreach(getActiveLanguages() as $index => $lang)
                    <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="tab_{{$lang->code}}">
                        <div class="form-group">
                            {!! Form::label('title['.$lang->code.']', trans('strings.LABEL_FOR_TITLE_MODULE_FORM').' '. $lang->name.':') !!}
                            {!! Form::text('title['.$lang->code.']', isset($module->translate($lang->code)->title) ? $module->translate($lang->code)->title : null, ['class' => 'form-control']) !!}
                        </div>
                    </div><!-- /.tab-pane -->
                @endforeach
                <div class="form-group">
                    {!! Form::label('enabled', trans('strings.LABEL_FOR_ENABLED_MODULE_FORM').':') !!}
                    <span>{{trans('strings.YES')}}: </span> {!! Form::radio('enabled', true, true) !!}
                    <span>{{trans('strings.NO')}}: </span> {!! Form::radio('enabled', false) !!}
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