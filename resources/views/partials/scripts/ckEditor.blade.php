@push('scripts')
<script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
<script>
    $(function () {
        $('.editor').each(function(val){
            var id = $( this ).attr('id');
            CKEDITOR.replace(id);
        })
    });
</script>
@endpush