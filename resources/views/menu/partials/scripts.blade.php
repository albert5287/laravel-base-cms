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

            $('#nestable3').nestable({
                maxDepth: 10
            });
            
            //we want this function to fire whenever the user types in the search-box
            $(".search-element").keyup(function () {
                var type = $(this).attr("elementType");
                //first we create a variable for the value from the search-box
                var searchTerm = $("#search-item-"+type).val();

                //then a variable for the list-items (to keep things clean)
                var listItem = $('#list-'+type+'-items').children('li');

                //extends the default :contains functionality to be case insensitive
                //if you want case sensitive search, just remove this next chunk
                $.extend($.expr[':'], {
                    'containsi': function(elem, i, match, array)
                    {
                        return (elem.textContent || elem.innerText || '').toLowerCase()
                                        .indexOf((match[3] || "").toLowerCase()) >= 0;
                    }
                });//end of case insensitive chunk


                //this part is optional
                //here we are replacing the spaces with another :contains
                //what this does is to make the search less exact by searching all words and not full strings
                var searchSplit = searchTerm.replace(/ /g, "'):containsi('")


                //here is the meat. We are searching the list based on the search terms
                $("#list-"+type+"-items li").not(":containsi('" + searchSplit + "')").each(function(e)   {

                    //add a "hidden" class that will remove the item from the list
                    $(this).addClass('hidden');

                });

                //this does the opposite -- brings items back into view
                $("#list-"+type+"-items li:containsi('" + searchSplit + "')").each(function(e) {

                    //remove the hidden class (reintroduce the item to the list)
                    $(this).removeClass('hidden');

                });

            });

            $('.add-menu').on('click', function(){
                //look which button have been press, to know in which list I have to do the search
                var btn_id = $(this).attr('id');
                var list = '';
                var nestabled = true;
                switch(btn_id){
                    //case to select the the list
                    case 'add-section-item':
                        list = 'list-section-items';
                        break;
                    case 'add-module-item':
                        list = 'list-module-items';
                        nestabled = false;
                        break;
                    default:
                        break;
                }
                //search for the selected items, and push them into an array
                var selected = [];
                $('#'+list+' input:checked').each(function(){
                    var element = new Object();
                    element['id'] = $(this).attr('data-id');
                    element['name'] = $(this).attr('data-name');
                    element['type'] = $(this).attr('data-type');
                    selected.push(element);
                    $(this).parent().parent().addClass('hidden'); //hide the element
                    $(this).attr('checked', false); //uncheck the element


                });
                console.log('selected', selected);
                var html_dd_menu = '';
                var noNestableClass = nestabled ? '' : 'dd-no-nestable';
                $.each(selected, function(index, value){
                    var data = 'data-element-id = "'+value['id']+'" list-element-name ="'+value['name']+'" data-element-type ="'+value['type']+'"';
                    html_dd_menu += '<li class="dd-item dd3-item '+noNestableClass+'" data-id="'+$.now()+'" '+data+' >'; //le pongo el $.now(), porque ya que pueden haber distintos tipos de elementos en la lista se puede dar el caso que el id se repita
                    html_dd_menu += '<div class="dd-handle dd3-handle"></div><div class="dd3-content">'+value['name']+'<!--<div class="remove">x</div><div class="mostrar-menu menu-oculto"><i class="fa fa-eye"></i>--></div></li>';
                })
                $("#nestable3 .father").append(html_dd_menu);
            });

            $("#btn-save-menu").on("click", function(){
                var menuName = $("#name").val();
                if(menuName == ''){
                    alert("Tienes que darle un nombre al menu");
                    $("#name").focus();
                    return false;
                }
                var menuElements = $('#nestable3').nestable('serialize');
                console.log('menuElements', menuElements);
                return false;
                $(".loader").css("display", "block");
                $.ajax({
                    type: "POST",
                    url: "./includes/ajax/guardar_estructura_menu.php",
                    data: {edit: edit, idMenu: idMenu, nombre: menuNombre, elementosMenu: elementosMenu, seccion: seccion, subseccion: subseccion}
                }).done(function(data) {
//            console.log(data);
                    window.location.replace(data);
                    activar_alerta_cambios();
                });
            });



        });


    </script>
@stop