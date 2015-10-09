@inject('multimedia', 'App\Media')
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
                                    @if(!($multimedia->allByApp()->get()->isEmpty()))
                                        @foreach($multimedia->allByApp()->get() as $media)
                                            <div class="dz-preview dz-image-preview">
                                                <label>
                                                <input type="checkbox" name="mediaSelected[]" value="{{$media}}">
                                                <div class="dz-image">
                                                    <img src="{{ asset('/'.$media->getThumbnail()) }}" width="120px"
                                                         height="120px" alt="{{$media->title}}">
                                                </div>
                                                <div class="dz-details">
                                                    <div class="dz-filename">
                                                        <span data-dz-name="">
                                                            {{$media->file_name}}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="dz-success-mark">
                                                    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                                        <title>Check</title>
                                                        <defs></defs>
                                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                            <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                                        </g>
                                                    </svg>
                                                </div>
                                                {{--{!! HTML::linkAction('MediaController@destroy', 'remove', array($media->id), array('class' => 'dz-remove remove-media', 'id' => $media->id )) !!}--}}
                                                {{--<a class="dz-remove remove-media" href="javascript:undefined;" id="{{$image->id}}" data-token="{{ csrf_token() }}">remove</a>--}}
                                                </label>
                                            </div>
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