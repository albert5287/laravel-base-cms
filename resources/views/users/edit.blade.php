@extends('app')
@section('content')
    {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user->id, $app_id]]) !!}
    @include('users.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')

@stop