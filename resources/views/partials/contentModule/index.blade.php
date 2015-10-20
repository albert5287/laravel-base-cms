@extends('app')

@section('content')
    <div class="row">
        @include('partials.contentModule.leftSide')
        <div class="col-md-10">
            @include('partials.table.table')
        </div>
    </div>

@stop