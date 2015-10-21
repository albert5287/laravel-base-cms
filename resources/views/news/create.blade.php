@extends('app')

@section('content')
    {!! Form::model($new = new \App\News, ['url' => 'news']) !!}
    {!! Form::text('module_application_id', $module_application_id, ['hidden' => true]) !!}
    @include('news.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop