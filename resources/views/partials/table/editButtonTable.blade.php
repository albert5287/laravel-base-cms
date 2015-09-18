@if(!(isset($editButton) && $editButton === false))
    <a href="{{action($class_name.'Controller@edit', [$element->id])}}" class="btn btn-info pull-left qs" style="margin-right: 3px;">
        <i class="fa fa-edit"></i>
        <span class="popover above">bearbeiten</span>
    </a>
@endif