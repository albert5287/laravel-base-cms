@extends('app')

@section('content')

    {!! Form::model($new = new \App\News, ['url' => 'news']) !!}
    @include('news.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop