@extends('app')
@section('content')
    {!! Form::model($role, ['method' => 'PATCH', 'action' => ['RoleController@update', $role->id, $app_id]]) !!}
    @include('roles.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')

@stop