@extends('app')
@section('content')
    {!! Form::model($new, ['method' => 'PATCH', 'action' => ['NewsController@update', $new->id]]) !!}
    @include('news.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')

@stop