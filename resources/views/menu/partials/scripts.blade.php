@section('scripts')
    <script>
        function goToSelectedMenu() {
            var urlTo = "{{ action('MenuController@edit', ['%menu_id%']) }}";
            var menu_id = $('#menu_id').val();
            if (menu_id > 0) {
                // swap out the placeholder dynamically using jQuery
                urlTo = urlTo.replace('%menu_id%', menu_id);
                // similar behavior as clicking on a link
                window.location.href = urlTo;
            }
        }
        $('#select_menu').on('click', goToSelectedMenu);

        $(document).ready(function(){

            $('ol.sortable').nestedSortable({
                forcePlaceholderSize: true,
                handle: 'div',
                helper:	'clone',
                items: 'li',
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                toleranceElement: '> div',
                isTree: true,
                expandOnHover: 700,
                startCollapsed: false
            });
            $('.disclose').on('click', function() {
                $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
            })
        });


    </script>
@stop