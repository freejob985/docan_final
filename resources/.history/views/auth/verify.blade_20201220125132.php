@extends('layouts.blank')

@section('content')
    <div class="cls-content-sm panel">
        <div class="panel-body">
            <h1 class="h3">تحقق من عنوان بريدك الإلكتروني</h1>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        تم إرسال رابط تحقق جديد إلى عنوان بريدك الإلكتروني.
                    </div>
                @endif

            {{ translate('Before proceeding, please check your email for a verification link.') }}
            {{ translate('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="btn-link text-bold text-main">{{ translate('Click here to request another') }}</a>.
        </div>
    </div>
@endsection
