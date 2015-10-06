<div class="col-md-3">
    <div class="box box-solid">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('strings.LABEL_FOR_SECTIONS_MENU')}}</h3>

                <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="margin-10">
                    <input type="text" id="search-item-section" class="search-element form-control" elementType="section"
                           placeholder="buscar">
                </div>
                <ul class="nav nav-pills nav-stacked">
                    <li>
                        <ul id="list-section-items" class="menu-items">
                            @foreach([1,2,3,4] as $index => $element)
                            <li>
                                <label class="menu-item-title">
                                    <input type="checkbox" class="menu-item-checkbox" data-id="{{$element}}" data-name="Section {{$element}}" data-type="{{MENU_ELEMENT_TYPE_SECTION}}">
                                    Section {{$element}}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <a href="#" class="pull-left">create new</a>
                        <input class="btn btn-primary pull-right margin-3 add-menu" id="add-section-item" type="submit" value="Add to Menu">
                    </li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
        <div class="box box-solid collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">{{trans('strings.LABEL_FOR_CONTENT_MODULE_MENU')}}</h3>

                <div class="box-tools">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="margin-10">
                    <input type="text" id="search-item-module" class="search-element form-control" elementType="module"
                           placeholder="buscar">
                </div>
                <ul class="nav nav-pills nav-stacked">
                    <li>
                        <ul id="list-module-items" class="menu-items">
                            @foreach([1,2,3,4] as $index => $element)
                                <li>
                                    <label class="menu-item-title">
                                        <input type="checkbox" class="menu-item-checkbox" data-id="{{$element}}" data-name="module {{$element}}" data-type="{{MENU_ELEMENT_TYPE_MODULE}}">
                                        Module {{$element}}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <input class="btn btn-primary pull-right margin-3 add-menu" type="submit" id="add-module-item" value="Add to Menu">
                    </li>
                </ul>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>