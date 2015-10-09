@extends('app')
@section('content')
    {!! Form::model($new, ['method' => 'PATCH', 'action' => ['ModuleController@update', $new->id]]) !!}
    @include('module.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')

@stop