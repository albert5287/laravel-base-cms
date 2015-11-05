@extends('app')

@section('content')
    @include('partials.application.edit', ['tab' => 'role', 'view' => 'partials.table.table'])
@stop