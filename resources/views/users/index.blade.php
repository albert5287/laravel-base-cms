@extends('app')

@section('content')
    @include('partials.application.edit', ['tab' => 'user', 'view' => 'partials.table.table'])
@stop