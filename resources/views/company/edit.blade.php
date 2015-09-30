@extends('app')
@section('content')
    {!! Form::model($company, ['method' => 'PATCH', 'action' => ['CompanyController@update', $company->id]]) !!}
    @include('company.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')

@stop