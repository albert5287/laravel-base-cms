@extends('app')

@section('content')

    {!! Form::model($application = new \App\Application, ['url' => 'apps']) !!}
    @include('application.partials.form', ['submitButtonText' => trans('strings.CREATE_SUBMIT_BUTTON_TEXT')])
    {!! Form::close() !!}

    @include('errors.list')
@stop