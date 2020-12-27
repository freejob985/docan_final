
@php
	echo $array['content'];
@endphp

 @php
	 $array['url'];
@endphp

<a href="{{ $data }}">Please click on the link to continue shopping</a>

Thanks,<br>
{{ config('app.name') }}
