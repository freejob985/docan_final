
@php
	echo $array['content'];
@endphp

 @php
	echo  $array['url'];
@endphp

<a href="<?php  $array['url'] ">برجاء النقر علي الرابط لمتابعة التسوق</a>
Thanks,<br>
{{ config('app.name') }}
