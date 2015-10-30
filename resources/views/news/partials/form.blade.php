<div class="box box-primary">
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @foreach(getActiveLanguages() as $index => $lang)
                    <li {{$index == 0 ? "class=active" : ''}}>
                        <a href="#tab_{{$lang->code}}" data-toggle="tab">{{$lang->name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach(getActiveLanguages() as $index => $lang)
                    <div class="tab-pane {{$index == 0 ? 'active' : ''}}" id="tab_{{$lang->code}}">
                        <div class="form-group">
                            {!! Form::label('title['.$lang->code.']', trans('strings.LABEL_FOR_TITLE').' '. $lang->name.':') !!}
                            {!! Form::text('title['.$lang->code.']', isset($new->translate($lang->code)->title) ? $new->translate($lang->code)->title : null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('subtitle['.$lang->code.']', trans('strings.LABEL_FOR_SUBTITLE').' '. $lang->name.':') !!}
                            {!! Form::textarea('subtitle['.$lang->code.']', isset($new->translate($lang->code)->subtitle) ? $new->translate($lang->code)->subtitle : null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('text['.$lang->code.']', trans('strings.LABEL_FOR_TEXT').' '. $lang->name.':') !!}
                            {!! Form::textarea('text['.$lang->code.']', isset($new->translate($lang->code)->text) ? $new->translate($lang->code)->text : null, ['class' => 'form-control editor']) !!}
                        </div>
                    </div><!-- /.tab-pane -->
                @endforeach
                <div class="form-group">
                    {!!Form::button(trans('strings.LABEL_FOR_ADD_MULTIMEDIA'), array('class' => 'btn',
                                                                                'data-toggle' => 'modal',
                                                                                'data-target' => '#media-modal',
                                                                                'data-limit-elements' => 2,
                                                                                'data-destination-div' => 'related-media',
                                                                                'data-destination-name' => '_relatedMedia[]',)) !!}
                </div>
                <div id="related-media" class="dropzone dropzone-previews">
                    @foreach($new->media as $media)
                        @include('partials.media.previewImage', ['inputName' => '_relatedMedia[]', 'checkboxChecked' => true,  'showRemoveLink' => true])
                    @endforeach
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer">

        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div><!-- /.box -->
@include('partials.media.modal')

@include('partials.scripts.ckEditor')
@include('partials.scripts.dropzone')
