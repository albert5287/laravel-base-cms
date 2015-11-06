@extends('app')
@section('content')
    {!! Form::model($new = new Bican\Roles\Models\Role, ['url' => 'roles/'.$app_id]) !!}
    {!! Form::text('app_id', $app_id, ['hidden' => true]) !!}
    @include('roles.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop