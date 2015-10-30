<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel DataTables Tutorial</title>

    <!-- Bootstrap CSS -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        body {
            padding-top: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <table class="table table-bordered" id="users-table">
        <thead>
        <tr>
            {{--<th>Id</th>--}}
            <th>Name</th>
            {{--<th>Email</th>--}}
            <th>Created At</th>
            <th>Updated At</th>
           {{-- <th>action</th>--}}
        </tr>
        </thead>
    </table>
</div>

<!-- jQuery -->
<script src="//code.jquery.com/jquery.js"></script>
<!-- DataTables -->
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- App scripts -->
@stack('scripts')
<script>
    $(function() {
        var table = $('#users-table')
                .DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! action('DatatablesController@data') !!}',
            columns: [
                //{ data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                /*{ data: 'subtitle', name: 'subtitle' },*/
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                //{data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            //order: [[1]],
            "displayStart": 0,
        });
        //table.search('new').draw();


        table.on('order.dt',  setUrl)
            .on('search.dt', setUrl)
            .on('page.dt', setUrl);


        function setUrl(){
            var order = table.order()[0];
            var page = table.page();
            var search = table.search();
            if (typeof (history.pushState) != "undefined") {
                var obj = { Url: '?sort='+order[0]+'&order='+order[1]+'&page='+page+'&search='+search };
                history.pushState(null, null, obj.Url);
            } else {
                alert("Browser does not support HTML5.");
            }
        }
    });
</script>
</body>
</html>