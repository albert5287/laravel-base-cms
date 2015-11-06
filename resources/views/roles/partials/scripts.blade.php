@push('scripts')
<script>
    //check all checkboxes
    $("#modules").change(function () {
        $("#table_permissions input:checkbox").prop('checked', $(this).prop("checked"));
    });
    //check all checkboxes in a column
    $(".headerPermissions").change(function(){
        var index = $(this).parent().index();
        $("#table_permissions tr td:nth-child("+(index+1)+") input[type=checkbox]").prop("checked", $(this).prop("checked"));
    });
    //check all checkboxes in a row
    $("#table_permissions tr td:nth-child(1) input[type=checkbox]").change(function(){
        $(this).parents('tr').find(':checkbox').prop('checked', $(this).prop("checked"));
    })
</script>
@endpush