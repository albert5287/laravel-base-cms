@extends('app')

@section('content')
    @include('menu.partials.mainHeader')
    <div class="row">
        @include('menu.partials.leftSide')
        <div class="col-md-9">
            @include('menu.partials.editMenuBox')
        </div>
    </div>

    @include('errors.list')
@stop
@include('menu.partials.scripts')