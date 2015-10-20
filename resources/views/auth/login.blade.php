<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>{{CMS_TITLE}}</title>

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">--}}


    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Events CMS</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{--<p class="login-box-msg">Sign in to start your session</p>--}}
        {!! Form::open(['route' => 'login', 'class' => 'form']) !!}
            <div class="form-group has-feedback">
                <input class="form-control" name="email" value="{{ old('email') }}" placeholder="UserName"/>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Password"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                {{--<div class="col-xs-8">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                    </div>
                </div>--}}
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
                </div>
            </div>

            {{-- <div class="form-group">
                 <a href="{{ url('/password/email') }}">Forgot Your Password?</a>
             </div>--}}
        {!! Form::close() !!}
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('/js/all.js') }}"></script>
</body>
</html>

{{--
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('form.login.title') }}</div>
                    <div class="panel-body">
                        {!! Form::open(['route' => 'login', 'class' => 'form']) !!}
                            <div class="form-group">
                                <label>{{ trans('form.label.email') }}</label>
                                {!! Form::email('email', '', ['class'=> 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>{{ trans('form.label.password') }}</label>
                                {!! Form::password('password', ['class'=> 'form-control']) !!}
                            </div>
                            <div class="checkbox">
                                <label><input name="remember" type="checkbox">{{ trans('form.label.remember') }}</label>
                            </div>
                            <div>                            
                                {!! Form::submit(trans('form.login.submit'),['class' => 'btn btn-primary']) !!}
                                <a href="{{ url('password/email') }}">{{ trans('passwords.forgot') }}</a>
                            </div>
                        {!! Form::close() !!}
                    </div> 
                </div>
            </div>
        </div>
    </div>
@endsection--}}
