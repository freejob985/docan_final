
@php
	echo $array['content'];
@endphp

 @php
	echo  $array['url'];
@endphp

<a href="<?php  $array['url'] "><?php echo  ?></a>
Thanks,<br>
{{ config('app.name') }}
