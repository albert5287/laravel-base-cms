<script>
    var limitElements = -1;
    var destinationDiv = 'related-media';
    var destinationName = '_relatedMedia[]';
    var showRemoveLink = true;

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
                console.log(response);
                //foreach file a add the checkbox
                $.each(files, function(index, value){
                    var id = response[index].id;
                    var element = $(value.previewElement);
                    var checkbox = '<input type="checkbox" name="mediaSelected[]" value="'+id+'">';
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

    //listener when the modal is opened
    $('#media-modal').on('show.bs.modal', openModal);

    //listener when the modal is closed
    $('#media-modal').on('hide.bs.modal', closeModal);

    //listener to limit the selected media
    $('#media-modal').on('change', '#previews input[type=checkbox]', limitSelectMedia);

    //listener to add the selected media in the form
    $('#insert_media_form').on('click', insertMediaForm);

    //listener to remove an image
    $('body').on('click', '.dz-remove', removeImage);

    //function triggered when the modal is opened
    function openModal(event){
        //get the data from the button
        var button = $(event.relatedTarget) // Button that triggered the modal

        limitElements = getButtonData(button, 'limit-elements');
        destinationDiv = getButtonData(button, 'destination-div');
        destinationName = getButtonData(button, 'destination-name');
        showRemoveLink = getButtonData(button, 'show-remove-link');

        //if limitElements is bigger than 1 and i already have reached the limit i can't select more items
        if(limitElements > 1 && $('#' + destinationDiv + ' .dz-preview').length >= limitElements){
            //remove disabled attribute
            $('#previews input[type=checkbox]').prop('disabled', true);
        }
    }

    //function triggered when the modal is closed
    function closeModal(){
        //I uncheck the elements from the modal
        $('#previews input[type=checkbox]').removeAttr('checked');
    }

    //function to put the selected media into the form
    function insertMediaForm(){
        //i get the selected images
        var selectedMedia = $('#previews input[type=checkbox]:checked').closest('.dz-image-preview');
        selectedMedia.each(function(){
            //get the source of the image
            var srcImage = $(this).find('img')[0].src;
            //if that image is not in the destination div the i put it
            if($('#'+destinationDiv +' img[src$="'+srcImage+'"]').length === 0) {
                //I clone the element and put it in the form
                var newElement = $(this).clone().appendTo('#' + destinationDiv);
                //I change the name attr
                newElement.find('input[type=checkbox]').attr('name', destinationName);
                //if remove link is set to true, I add the remove link
                if(showRemoveLink){
                    var removeLink = '<a class="dz-remove remove-media">remove</a>';
                    newElement.append(removeLink);
                }
            }
        });
        //workaround to set to readonly the checkboxes on the form
        $('#related-media input[type=checkbox]').on('click', function(){
            return false;
        });
        //close the modal
        $('#media-modal').modal('hide');
    }

    //function to limit the media that can be selected
    function limitSelectMedia(){
        if(limitElements > 0){
            var checkboxes = $('#previews input[type=checkbox]');
            var current = checkboxes.filter(':checked').length;
            if(limitElements === 1){
                checkboxes.filter(':not(:checked)').prop('disabled', current >= limitElements);
            }
            else{
                var mediaAlreadySelected = $('#' + destinationDiv + ' .dz-preview').length;
                checkboxes.filter(':not(:checked)').prop('disabled', (current + mediaAlreadySelected) >= limitElements);
            }


        }
    }

    //function to get the data from the button
    function getButtonData(button, attr){
        //if the data is set is returned
        if(button.data(attr) !== undefined) {
            return button.data(attr)
        }
        //otherwise return the default value
        else{
            return window[$.camelCase(attr)];
        }
    }

    //function to remove an image
    function removeImage(){
        $(this).closest('.dz-image-preview').remove();
    }

</script>