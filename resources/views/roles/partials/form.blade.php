<div class="box box-primary">
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('name', trans('strings.LABEL_NAME').':') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', trans('strings.LABEL_DESCRIPTION').':') !!}
            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label>{{trans('strings.LABEL_PERMISSIONS')}}:</label>
            <table class="table" id="table_permissions">
                <tbody>
                    <tr>
                        <th>
                            <input type="checkbox" id="modules">
                            <label for="modules">{{trans('strings.LABEL_MODULES')}}</label>
                        </th>
                        <th>
                            <input type="checkbox" id="show" class="headerPermissions">
                            <label for="show">{{trans('strings.LABEL_SHOW')}}</label>
                        </th>
                        <th>
                            <input type="checkbox" id="create" class="headerPermissions">
                            <label for="create">{{trans('strings.LABEL_CREATE')}}</label>
                        </th>
                        <th>
                            <input type="checkbox" id="edit" class="headerPermissions">
                            <label for="edit">{{trans('strings.LABEL_EDIT')}}</label>
                        </th>
                        <th>
                            <input type="checkbox" id="delete" class="headerPermissions">
                            <label for="delete">{{trans('strings.LABEL_DELETE')}}</label>
                        </th>
                    </tr>
                    @foreach($modulesApplication as $index => $module)
                        <tr>
                            <td>
                                <input type="checkbox" id="module_{{$index}}">
                                <label for="module_{{$index}}">{{$module->title}}</label>
                            </td>
                            <td>{!! Form::checkbox('permissions[show.'.$app_id.'.'.$module->class.']', 1, in_array('show.'.$app_id.'.'.$module->class, $arrayPermissions)) !!}</td>
                            <td>
                                @if($module->class !== 'Application')
                                    {!! Form::checkbox('permissions[create.'.$app_id.'.'.$module->class.']', 1, in_array('create.'.$app_id.'.'.$module->class, $arrayPermissions)) !!}
                                @endif
                            </td>
                            <td>{!! Form::checkbox('permissions[edit.'.$app_id.'.'.$module->class.']', 1, in_array('edit.'.$app_id.'.'.$module->class, $arrayPermissions)) !!}</td>
                            <td>
                                @if($module->class !== 'Application')
                                    {!! Form::checkbox('permissions[delete.'.$app_id.'.'.$module->class.']', 1, in_array('delete.'.$app_id.'.'.$module->class, $arrayPermissions)) !!}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
<!-- /.box -->
@include('roles.partials.scripts')