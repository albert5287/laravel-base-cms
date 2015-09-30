@extends('app')

@section('content')

    {!! Form::model($language = new \App\Language, ['url' => 'languages']) !!}
    @include('language.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop