@extends('app')
@section('content')
    {!! Form::model($module, ['method' => 'PATCH', 'action' => ['ModuleApplicationController@update', $module->id]]) !!}
    @include('modules-app.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')

@stop