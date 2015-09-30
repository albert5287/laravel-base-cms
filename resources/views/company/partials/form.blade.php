<div class="box box-primary">
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('name', trans('strings.LABEL_FOR_NAME_COMPANY_FORM').':') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('street', trans('strings.LABEL_FOR_STREET_COMPANY_FORM').':') !!}
            {!! Form::text('street', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('city', trans('strings.LABEL_FOR_CITY_COMPANY_FORM').':') !!}
            {!! Form::text('city', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('phone', trans('strings.LABEL_FOR_PHONE_COMPANY_FORM').':') !!}
            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', trans('strings.LABEL_FOR_EMAIL_COMPANY_EMAIL').':') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
<!-- /.box -->

@section('scripts')
    @include('partials.formScripts')
@stop