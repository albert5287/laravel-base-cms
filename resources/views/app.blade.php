<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>{{CMS_TITLE}}</title>

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue">
<div class="wrapper">

    @include ('partials.layout.header')

    @include ('partials.layout.sidebar')


            <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include ('partials.layout.contentHeader')
                <!-- Main content -->
        <section class="content">
            @include ('flash::message')
            @yield('content')
        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->

    @include('partials.layout.footer')

</div><!-- ./wrapper -->

<!-- Scripts -->
<script src="{{ asset('/js/all.js') }}"></script>
@stack('scripts')
</body>
</html>
