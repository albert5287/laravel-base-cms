<?php

?>
<thead>
    <tr>
        @foreach($headerTable as $key => $header)
            <th>
                {{--<a href="{{action($class_name.'Controller@index',array_merge(array('sort' => $key, 'order' => 'asc'), $array))}}">
                    <i class="fa fa-chevron-up"></i>
                </a>
                <a href="{{action($class_name.'Controller@index', array_merge(array('sort' => $key, 'order' => 'desc'),$array))}}">
                    <i class="fa fa-chevron-down"></i>
                </a>--}}
                {{$header}}
            </th>
        @endforeach
        <th style="min-width: 75px">Aktion</th>
    </tr>
</thead>