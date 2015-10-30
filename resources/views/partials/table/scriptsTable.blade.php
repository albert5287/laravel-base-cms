@push('scripts')
    <script id="modal">
        $('#modal').on('shown.bs.modal', function (event) {
            var option = $(event.relatedTarget) // Button that triggered the modal
            $('#modalLabel').html(option.data('title'));
            $('.modal-body').html(option.data('body'));
            $('#btnConfirm').html(option.data('btnconfirm'));
            $('#btnConfirm').attr('data-form', option.data('form'));
                    @if($class_name === 'User')
                        var userId = option.data('elementid');
            var token = option.data('elementid');
            $.ajax({
                type: 'post', // or post?
                dataType: 'json',
                url: '{{action('UserController@getInfoWedding')}}', // change as needed
                data: {id: userId, _token: '{{csrf_token()}}'}, // if you are posting
                success: function (data) {
                    var body = "<p>By Deleting this user you're going to delete the wedding with date " + data.date + ".</p>"
                    body += "<p>And the users with the folowing email: <ul><li>" + data.email1 + '</li> <li>' + data.email2 + '</li></ul></p>';
                    $('.modal-body').html(body);
                },
                error: function (xhr, textStatus, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            @endif


        });

        $('#btnConfirm').click(function () {

            // handle form processing here
            var form = $(this).attr('data-form');
            $('#' + form).submit();

        });
    </script>

    <!-- DataTables -->
    <script id="datatables">
        $(function () {
            var table = $('#table')
                    .DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: '{!! action($class_name.'Controller@data',$module_application_id > 0 ?[$module_application_id] : []) !!}',
                        columns: [
                                @foreach($headerTable as $key => $value)
                                    {data: '{{$key}}', name: '{{$key}}'},
                                @endforeach
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                        ],
                        @if($sort !== false && $order !== false)
                            order: [[{{$sort}}, '{{$order}}']],
                        @endif
                        @if($page > 0)
                            displayStart: {{$page*10}},
                        @endif

                    });
            @if($search !== '')
                table.search('{{$search}}').draw();
            @endif


            table.on('order.dt', setUrl)
                    .on('search.dt', setUrl)
                    .on('page.dt', setUrl);


            function setUrl() {
                var order = table.order()[0];
                var page = table.page();
                var search = table.search();
                if (typeof (history.pushState) != "undefined") {
                    var obj = {Url: '?sort=' + order[0] + '&order=' + order[1] + '&page=' + page + '&search=' + search};
                    history.pushState(null, null, obj.Url);
                } else {
                    alert("Browser does not support HTML5.");
                }
            }
        });
    </script>
@endpush