@extends('app')

@section('content')

    {!! Form::model($company = new \App\Company, ['url' => 'companies']) !!}
    @include('company.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop