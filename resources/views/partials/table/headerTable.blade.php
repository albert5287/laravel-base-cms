<?php

?>
<thead>
    <tr>
        @foreach($headerTable as $key => $header)
            <th>
                {{$header}}
            </th>
        @endforeach
        <th>Aktion</th>
    </tr>
</thead>