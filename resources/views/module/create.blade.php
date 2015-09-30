@extends('app')

@section('content')

    {!! Form::model($module = new \App\Module, ['url' => 'modules']) !!}
    @include('module.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop