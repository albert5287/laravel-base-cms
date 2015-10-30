@if(!(isset($addButton) && $addButton === false))
    @if($module_application_id > 0)
        <a href="{{action($class_name.'Controller@create', [$module_application_id])}}" class="btn btn-success"><i class="fa fa-plus"></i> hinzufügen</a>
    @else
        <a href="{{action($class_name.'Controller@create')}}" class="btn btn-success"><i class="fa fa-plus"></i> hinzufügen</a>
    @endif
@endif