@if(!(isset($editButton) && $editButton === false))
    @if($module_application_id > 0)
        <a href="{{action($class_name.'Controller@edit', [$element->id, $module])}}" class="btn btn-info pull-left qs" style="margin-right: 3px;">
            <i class="fa fa-edit"></i>
            <span class="popover above">bearbeiten id</span>
        </a>
    @else
        <a href="{{action($class_name.'Controller@edit', [$element->id])}}" class="btn btn-info pull-left qs" style="margin-right: 3px;">
            <i class="fa fa-edit"></i>
            <span class="popover above">bearbeiten noID</span>
        </a>
    @endif
@endif