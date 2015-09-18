@if(!(isset($addButton) && $addButton === false))
    <a href="{{action($class_name.'Controller@create')}}" class="btn btn-success"><i class="fa fa-plus"></i> hinzufügen</a>
@endif