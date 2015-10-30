<div class="box box-primary">
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('company_id', trans('strings.LABEL_FOR_COMPANY_APPLICATION_FORM').':') !!}
            {!! Form::select('company_id', $companies, null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('name', trans('strings.LABEL_FOR_NAME_APPLICATION_FORM').':') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('modules', trans('strings.LABEL_FOR_MODULES_APPLICATION_FORM').':') !!}
            @foreach($modules as $key => $value)
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('_modules[]', $key, $application->availableModules->where('id', $key)->isEmpty() ? false : true) !!}
                        {{$value}}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
<!-- /.box -->
