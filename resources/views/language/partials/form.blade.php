<div class="box box-primary">
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('code', trans('strings.HEADER_TABLE_FOR_CODE_IN_LANGUAGES').':') !!}
            {!! Form::text('code', null, ['class' => 'form-control']) !!}
        </div>
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
                            {!! Form::label('name['.$lang->code.']', trans('strings.HEADER_TABLE_FOR_NAME_IN_LANGUAGES').':') !!}
                            {!! Form::text('name['.$lang->code.']', isset($language->translate($lang->code)->name) ? $language->translate($lang->code)->name : null, ['class' => 'form-control']) !!}
                        </div>
                    </div><!-- /.tab-pane -->
                @endforeach
            </div><!-- /.tab-content -->
        </div><!-- nav-tabs-custom -->

    </div><!-- /.box-body -->
    <div class="box-footer">

        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div><!-- /.box -->

@section('scripts')
    @include('partials.formScripts')
@stop