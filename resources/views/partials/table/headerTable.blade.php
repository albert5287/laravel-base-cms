<?php

?>
<thead>
    <tr>
        @foreach($headerTable as $key => $header)
            <th>
                {{$header}}
            </th>
        @endforeach
        <th style="min-width: 75px">Aktion</th>
    </tr>
</thead>