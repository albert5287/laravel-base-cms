<link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="http://cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/locales/bootstrap-datepicker.de.min.js"></script>

<script>
    $( document ).ready(function() {
        $(".datepicker").datepicker({
            language: 'de'
        });
    });
</script>

<script src="{{ asset('/vendors/ckeditor/ckeditor.js') }}"></script>
<script>
    $(function () {
        $('.textarea').each(function(val){
            var id = $( this ).attr('id');
            CKEDITOR.replace(id);
        })


    });
</script>

<script>

    Dropzone.options.uploaderDropzone = {
        // The configuration we've talked about above
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        maxFilesize: 4,
        previewsContainer: "#previews", // Define the container to display the previews
        clickable:'#previews',
        addRemoveLinks: true,
        dictRemoveFile: 'test remove', //text to remove file
        acceptedFiles: ".jpeg,.jpg,jpe,.png,audio/*,.pdf,.zip",

        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;

            // First change the button to actually tell Dropzone to process the queue.
            this.element.querySelector("input[type=submit]").addEventListener("click", function(e) {
                if(myDropzone.getQueuedFiles().length > 0) {
                    console.log(myDropzone.getQueuedFiles())
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                }
            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
            });
            this.on("successmultiple", function(files, response) {
                window.location.href = "{{URL::to('impulse')}}";
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
            });
            this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
            });
        }
    };
</script>
