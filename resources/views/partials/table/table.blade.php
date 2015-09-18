@include('partials.addButtonTable')
@include('partials.exportButtonTable')
<div class="box">
    <div class="box-body">
        @include('partials.searchBarTable')
        <table id="table" class="table table-bordered table-striped">
            @include('partials.headerTable')
            <tbody>
            @foreach($elements as $element)
                <tr>
                    @foreach($header_table as $key => $value)
                        @if(get_parent_class ($element->$key) === 'DateTime')
                            <td>{{$element->$key->format('d.m.Y H:i:s')}}</td>
                        @else
                            <td>{{$element->$key}}</td>
                        @endif
                    @endforeach
                    <td>
                        @include('partials.editButtonTable')
                        @include('partials.pushNotificationButtonTable')
                        @include('partials.deleteButtonTable')
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div> {!! str_replace('/?', '?', $search === "" ? $elements->appends(['order' => $order, 'sort' => $sort])->render() : $elements->appends(['order' => $order, 'sort' => $sort, 'search' => $search])->render()) !!} </div>
    </div><!-- /.box-body -->
</div><!-- /.box -->
@include('partials.modal')
@include('partials.addButtonTable')
@include('partials.scriptsTable')
