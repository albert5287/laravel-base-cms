@inject('media', 'App\Media')
<?php $multimedia = $media->allByApp()->get(); ?>
        <!-- Modal -->
<div class="modal fade" id="media-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{trans('strings.LABEL_INSERT_MEDIA')}}</h4>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li>
                            <a href="#tab_upload" data-toggle="tab">{{trans('strings.LABEL_UPLOAD_FILE')}}</a>
                        </li>
                        <li class="active">
                            <a href="#tab_library" data-toggle="tab">{{trans('strings.LABEL_MEDIA_LIBRARY')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab_upload">
                            <div class="dropzone" id="dropzoneFileUpload">
                                <button id="submit-files" class="hidden">Submit all files</button>
                                <div class="dz-default dz-message" data-dz-message="">
                                    <span>Drop files here to upload</span>
                                </div>
                            </div>
                            {{--<div class="dropzone-box">
                                <div id="previews" class="dropzone-previews">
                                    <div class="dz-default dz-message" data-dz-message="">
                                        <span>Drop files here to upload</span>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="tab_library">
                            <div class="dropzone">
                                <div id="previews" class="dropzone-previews">
                                    @if(!($multimedia->isEmpty()))
                                        @foreach($multimedia as $media)
                                            @include('partials.media.previewImage', ['inputName' => 'mediaSelected[]', 'checkboxChecked' => false])
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="insert_media_form">{{trans('strings.INSERT_MEDIA')}}</button>
            </div>
        </div>
    </div>
</div>