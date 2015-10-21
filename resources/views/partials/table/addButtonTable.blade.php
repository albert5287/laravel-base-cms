@if(!(isset($addButton) && $addButton === false))
    @if(isset($module) && $module !== NULL)
        <a href="{{action($class_name.'Controller@create', [$module])}}" class="btn btn-success"><i class="fa fa-plus"></i> hinzufügen</a>
    @else
        <a href="{{action($class_name.'Controller@create')}}" class="btn btn-success"><i class="fa fa-plus"></i> hinzufügen</a>
    @endif
@endif