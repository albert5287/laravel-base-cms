<div class="col-md-2">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Modules</h3>
        </div>
        <div class="box-body">
            <ul class="nav nav-pills nav-stacked">
                <li>
                    <ul id="list-section-items" class="menu-items">
                        @foreach(getContentModulesForCurrentApp() as $index => $element)
                        <li>
                            <label class="menu-item-title">
                                <a href="{{url($element->moduleType.'/'.$element->id)}}" class="{{HTML::isActive($element->moduleType.'/'.$element->id)}}">{{$element->name}}</a>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
            <!-- /.box-body -->
    </div>
</div>