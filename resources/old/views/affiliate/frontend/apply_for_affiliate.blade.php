@extends('frontend.layouts.app')

@section('content')

<link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

<style>
    label {

        font-size: 14px;
    }
</style>
    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-9 mx-auto">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{translate('Affiliate Informations')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{translate('Home')}}</a></li>
                                            <li class="active"><a href="{{ route('affiliate.apply') }}">{{translate('Affiliate')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{ route('affiliate.store_affiliate_user') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (!Auth::check())
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2">
                                        {{translate('User Info')}}
                                    </div>
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group--style-1">
                                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{ translate('Name') }}" name="name">
                                                        <span class="input-group-addon">
                                                            <i class="text-md la la-user"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group--style-1">
                                                        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email">
                                                        <span class="input-group-addon">
                                                            <i class="text-md la la-envelope"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group--style-1">
                                                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ translate('Password') }}" name="password">
                                                        <span class="input-group-addon">
                                                            <i class="text-md la la-lock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group--style-1">
                                                        <input type="password" class="form-control" placeholder="{{ translate('Confirm Password') }}" name="password_confirmation">
                                                        <span class="input-group-addon">
                                                            <i class="text-md la la-lock"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{translate('Verification info')}}
                                </div>
                                @php
                                    $verification_form = \App\AffiliateConfig::where('type', 'verification_form')->first()->value;
                                @endphp
                                <div class="form-box-content p-3">
                                    @foreach (json_decode($verification_form) as $key => $element)
                                        @if ($element->type == 'text')
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{ $element->label }} <span class="required-star">*</span></label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="{{ $element->type }}" class="form-control mb-3" placeholder="{{ $element->label }}" name="element_{{ $key }}" required>
                                                </div>
                                            </div>
                                        @elseif($element->type == 'file')
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{ $element->label }}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="{{ $element->type }}" name="element_{{ $key }}" id="file-{{ $key }}" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" required/>
                                                    <label for="file-{{ $key }}" class="mw-100 mb-3">
                                                        <span></span>
                                                        <strong>
                                                            <i class="fa fa-upload"></i>
                                                            {{translate('Choose file')}}
                                                        </strong>
                                                    </label>
                                                </div>
                                            </div>
                                        @elseif ($element->type == 'select' && is_array(json_decode($element->options)))
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{ $element->label }}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="mb-3">
                                                        <select class="form-control selectpicker" data-minimum-results-for-search="Infinity" name="element_{{ $key }}" required>
                                                            @foreach (json_decode($element->options) as $value)
                                                                <option value="{{ $value }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($element->type == 'multi_select' && is_array(json_decode($element->options)))
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{ $element->label }}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="mb-3">
                                                        <select class="form-control selectpicker" data-minimum-results-for-search="Infinity" name="element_{{ $key }}[]" multiple required>
                                                            @foreach (json_decode($element->options) as $value)
                                                                <option value="{{ $value }}">{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($element->type == 'radio')
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>{{ $element->label }}</label>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="mb-3">
                                                        @foreach (json_decode($element->options) as $value)
                                                            <div class="radio radio-inline">
                                                                <input type="radio" name="element_{{ $key }}" value="{{ $value }}" id="{{ $value }}" required>
                                                                <label for="{{ $value }}">{{ $value }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                             {{--  Personal Informations  --}}

                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{translate('Personal info')}}
                                </div>

                                <div class="form-box-content p-3">

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>  {{translate('Personal info')}}  <span class="required-star">*</span></label>
                                                </div>
                                                <div class="col-md-10">
                                                    <textarea id="summernote" name="bio" required></textarea>
                                                </div>
                                            </div>


                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="submit" class="btn btn-styled btn-base-1">{{translate('Save')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>

        $(document).ready(function() {
            $('#summernote').summernote();
          });

    </script>
@endsection
