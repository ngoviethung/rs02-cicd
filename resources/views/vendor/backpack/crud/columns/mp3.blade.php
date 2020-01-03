{{-- regular object attribute --}}
@php
	$value = data_get($entry, $column['name']);

	if (is_array($value)) {
		$value = json_encode($value);
	}
@endphp

<span>
    @if( isset($value) )
    <audio controls>
      <source src="{{url($value)}}" type="audio/mpeg">
    </audio>
    
    @else
    -
    @endif
</span>