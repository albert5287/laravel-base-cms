@extends('app')
@section('content')
    {!! Form::model($module, ['method' => 'PATCH', 'action' => ['ModuleController@update', $module->id]]) !!}
    @include('module.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')

@stop