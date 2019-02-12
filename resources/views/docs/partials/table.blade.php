@php
    $headers = $headers ?? [];
    $rows = $rows ?? [];
    foreach($rows as $n => $row) {
        $rows[$n][0] = "**{$rows[$n][0]}**";
        foreach($row as $n2 => $cell) {
            //$rows[$n][$n2] = nl2br($cell);
            if (is_array($cell)) {
                $rows[$n][$n2] = implode("<br/><br/>", $cell);
            }
        }
    }
@endphp

@if($headers)
{{ implode(' | ', $headers) }}
@else
|
@endif
------------- | -------------
@foreach($rows as $row)
{!! implode(' | ', $row) !!}
@endforeach