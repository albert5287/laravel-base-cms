<script>
    var limitElements = -1;
    var destinationDiv = 'related-media';

    $('#media-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        if(button.data('limit-elements') !== 'undefined'){
            limitElements = button.data('limit-elements');
        }
        if(button.data('destination-div') !== 'undefined'){
            destinationDiv = button.data('destination-div');
        }
    });

    $('#media-modal').on('change', '#previews input[type=checkbox]', limitSelectMedia);

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneFileUpload", {
        url: '{{action('MediaController@store')}}',
        params: {
            _token: '{{ Session::getToken() }}'
        },
        clickable:'#dropzoneFileUpload',
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        maxFilesize: 4,
        addRemoveLinks: true,
        acceptedFiles: ".jpeg,.jpg,jpe,.png,audio/*,.pdf,.zip",
        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;

            this.on("addedfile", function(file) {
                var element = $('#previews').prepend(file.previewElement);
            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
                //the tab is changed
                $('.nav-tabs a[href=#tab_library]').tab('show') ;
            });

            // Gets triggered when the files have successfully been sent.
            // Redirect user or notify of success.
            this.on("successmultiple", function(files, response) {
                //foreach file a add the checkbox
                $.each(files, function(index, value){
                    var element = $(value.previewElement);
                    var checkbox = '<input type="checkbox" name="mediaSelected[]" value="">';
                    element.html('<label>'+checkbox+element.html()+'</label>');
                    element.removeClass('dz-success');
                });
                //some classes are removed
                $('.dz-remove').remove();
                $('.dz-size').remove();
                $('.dz-progress').remove();
                $('.dz-error-message').remove();


            });
            this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
            });
        }
    });

    $('#insert_media_form').on('click', insertMediaForm);

    function insertMediaForm(){
        var selectedMedia = $('#previews input[type=checkbox]:checked').closest('.dz-image-preview');
        selectedMedia.each(function(){
            //I clone the element and put it in the form
            $(this).clone().appendTo('#'+destinationDiv);
        });
        //I uncheck the elements from the modal
        $('#previews input[type=checkbox]').removeAttr('checked');
        //workaround to set to readonly the checkboxes on the form
        $('#related-media input[type=checkbox]').on('click', function(){
            return false;
        });
        //close the modal
        $('#media-modal').modal('hide');
    }

    function limitSelectMedia(){
        if(limitElements > 0){
            var checkboxes = $('#previews input[type=checkbox]');
            var current = checkboxes.filter(':checked').length;
            checkboxes.filter(':not(:checked)').prop('disabled', current >= limitElements);
        }
    }

</script>