@if(!(isset($deleteButton) && $deleteButton === false))
    {!! Form::open([
    'action' => [$class_name.'Controller@destroy', $element->id],
    'method' => 'DELETE',
    'id' => 'deleteForm_'.$element->id]) !!}
    <button type="button" class="btn btn-danger qs" data-toggle="modal" data-target="#modal" data-title="Löschen?"
            data-body="Möchten Sie den Eintrag wirklich löschen?" data-btnconfirm="Löschen" data-form="{{'deleteForm_'.$element->id}}" data-elementid="{{$element->id}}">
        <i class="fa fa-trash"></i><span class="popover above">löschen</span>
    </button>
    {!! Form::close() !!}
@endif

