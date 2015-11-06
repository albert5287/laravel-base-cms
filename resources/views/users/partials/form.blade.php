<div class="box box-primary">
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('name', trans('strings.LABEL_NAME').':') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', trans('strings.LABEL_EMAIL').':') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', trans('strings.LABEL_PASSWORD').':') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('rolesList', trans('strings.LABEL_ROLES').':') !!}
            {!! Form::select('roleList[]', $rolesApplication, $userRoles, ['class' => 'form-control', 'multiple']) !!}
        </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
<!-- /.box -->
@include('roles.partials.scripts')