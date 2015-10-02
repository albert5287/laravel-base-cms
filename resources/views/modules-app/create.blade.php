@extends('app')

@section('content')

    {!! Form::model($module = new \App\ModuleApplication, ['url' => 'modules-app']) !!}
    @include('modules-app.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop