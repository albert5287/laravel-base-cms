@section('scripts')
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
                    success: function(data) {
                        var body = "<p>By Deleting this user you're going to delete the wedding with date "+data.date+".</p>"
                        body += "<p>And the users with the folowing email: <ul><li>"+ data.email1+'</li> <li>'+data.email2+'</li></ul></p>';
                        $('.modal-body').html(body);
                    },
                    error: function(xhr, textStatus, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            @endif

        });

        $('#btnConfirm').click(function() {

            // handle form processing here
            var form = $(this).attr('data-form');
            $('#'+form).submit();

        });
    </script>
    <script id="search-bar">
        //if the search variable is not empty then i put its value in the input box
        @if($search !== '')
            $('#searchBar').val('{{$search}}');
        @endif

        //listener for when the enter key is press
        $('#searchBar').keyup(function(e){
            if(e.keyCode === 13){
                $(this).trigger("searchFunction");
            }
        });


        //make the search
        $('#searchBar').bind("searchFunction", function(e){
            var url = window.location.href;
            if(url.indexOf('?') >= 0){
                var aux = url.split('?');
                url = aux[0];
            }
            window.location.href = $(this).val() === '' ?  url + '?sort=' + '{{$sort}}'+ '&order=' + '{{$order}}' : url + '?sort=' + '{{$sort}}'+ '&order=' + '{{$order}}' + '&search=' +$(this).val();
        })

    </script>
@endsection