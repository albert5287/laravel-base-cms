@extends('app')
@section('content')
    {!! Form::model($language, ['method' => 'PATCH', 'action' => ['LanguageController@update', $language->id]]) !!}
    @include('language.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')

@stop