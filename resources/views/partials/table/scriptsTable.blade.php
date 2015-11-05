@push('scripts')
    <script id="modal">
        $('#modal').on('shown.bs.modal', function (event) {
            var option = $(event.relatedTarget) // Button that triggered the modal
            $('#modalLabel').html(option.data('title'));
            $('.modal-body').html(option.data('body'));
            $('#btnConfirm').html(option.data('btnconfirm'));
            $('#btnConfirm').attr('data-form', option.data('form'));
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
                        autoWidth: false,
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