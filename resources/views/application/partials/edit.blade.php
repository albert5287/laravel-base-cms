{!! Form::model($application, ['method' => 'PATCH', 'action' => ['ApplicationController@update', $application->id]]) !!}
@include('application.partials.form', ['submitButtonText' => trans('strings.EDIT_SUBMIT_BUTTON_TEXT')])
{!! Form::close() !!}

@include('errors.list')