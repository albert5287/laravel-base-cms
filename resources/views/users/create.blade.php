@extends('app')
@section('content')
    {!! Form::model($role = new App\User, ['url' => 'users/'.$app_id]) !!}
    {!! Form::text('app_id', $app_id, ['hidden' => true]) !!}
    @include('users.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop