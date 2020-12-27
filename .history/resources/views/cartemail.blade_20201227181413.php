
@php
	echo $array['content'];
@endphp

 @php
	echo  $array['url'];
@endphp

<a href="<?php  $array['url'] "></a>
Thanks,<br>
{{ config('app.name') }}
