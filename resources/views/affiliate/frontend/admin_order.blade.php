@extends('frontend.layouts.app')


<link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">

<style>
    .buttons-html5 {
        border-color: #2ecc71;
        background: #2ecc71;
        box-shadow: none;
        border-radius: 3px;
        color: #fff;
        font-size: 14px;
        padding: 1px 10px;
    }

    .label {
        border-radius: 13px;
        padding: 0px 10px;
        color: #fff;
    }

    .label-success {
        background: green;
    }

    .label-info {
        background: blue
    }

    .label-danger {
        background: red
    }

    .label-warning {
        background: yellow
    }

    .main-ul {}

    .main-ul li {
        list-style: none;
        margin: 5px 10px;
        display: initial;
    }

    .sub-ul li {
        display: ruby-text;
    }



    button.dt-button {
        border: navajowhite;
        margin-bottom: 4%;
    }
</style>
@section('content')
<section class="gry-bg py-4 profile">
    <div class="container">
        <div class="row cols-xs-space cols-sm-space cols-md-space">
            <div class="col-lg-3 d-none d-lg-block">
                @if(Auth::user()->user_type == 'seller')
                @include('frontend.inc.seller_side_nav')
                @elseif(Auth::user()->user_type == 'customer')
                @include('frontend.inc.customer_side_nav')
                @endif
            </div>

            <div class="col-lg-9">
                <div class="main-content">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12 d-flex align-items-center">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{translate('Affiliate')}}
                                </h2>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{translate('Home')}}</a></li>
                                        <li><a href="{{ route('dashboard') }}">{{translate('Dashboard')}}</a></li>
                                        <li class="active"><a
                                                href="{{ route('affiliate.user.index') }}">{{translate('Affiliate System')}}</a>
                                        </li>
                                    </ul>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>

         

                    @if (\App\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                    \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated &&
                    \App\AffiliateOption::where('type', 'user_registration_first_purchase')->first()->status)
                    <div class="row">
                        @php
                        if(Auth::user()->referral_code == null){
                        Auth::user()->referral_code = substr(Auth::user()->id.Str::random(), 0, 10);
                        Auth::user()->save();
                        }
                        $referral_code = Auth::user()->referral_code;
                        $referral_code_url = URL::to('/users/registration')."?referral_code=$referral_code";
                        @endphp
                        <div class="col">
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-content p-3">
                                    <div class="form-group">
                                        <textarea id="referral_code_url" class="form-control" readonly
                                            type="text">{{$referral_code_url}}</textarea>
                                    </div>
                                    <button type=button id="ref-cpurl-btn" class="btn btn-base-1"
                                        data-attrcpy="{{translate('Copied')}}"
                                        onclick="copyToClipboard('url')">{{translate('Copy Url')}}</button>

                            
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif


                </div>

            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="card no-border mt-5">


                        <div class="card-body">
                            <table class="example table table-sm table-responsive-md mb-0 table-bordered">


                                <thead>
                                    <tr>
                                        <th>رقم الوصفه</th>
                                        <th> اسم العميل</th>
                                        <th>اللينك</th>
                                        <th>الوصفه الطبيه</th>
                                        <th>التاريخ</th>
                                        <th>السعر الكلي</th>
                                        <th> العموله</th>
                                        <th>عرض</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    @foreach ($orders as $order)
                                    <tr>
                                        <th>{{ $order->id}}</th>
                                        <th>
                                            @php $reals = App\Order::where('token', '=',
                                            $order->token)->latest()->get(); @endphp

                                            @foreach ($reals as $real)
                                            <ul class="main-ul">
                                                @php $delivery_status = $real->orderDetails->first()->delivery_status;
                                                @endphp
                                                <li style="
                                                display: grid;
                                            "> {{ $real->user->name }} </li>
                                                <li style="
                                                display: grid;
                                            "> {{ $real->user->email }} </li>
                                                <li style="
                                                display: grid;
                                            "> {{ $real->user->phone }} </li>

                                                <li> @if ($delivery_status == 'pending') <span
                                                        class="label label-danger">
                                                        {{translate('Pending')}} </span>
                                                    @endif
                                                    @if ($delivery_status == 'on_review') <span
                                                        class="label label-warning"> {{translate('On review')}} </span>
                                                    @endif
                                                    @if ($delivery_status == 'on_delivery') <span
                                                        class="label label-info"> {{translate('On delivery')}} </span>
                                                    @endif
                                                    @if ($delivery_status == 'delivered') <span
                                                        class=" label label-success"> {{translate('Delivered')}} </span>
                                                    @endif
                                                </li>

                                                <hr>
                                                <table class=" example table table-bordered">


                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>{{ translate('Name') }}</th>
                                                            <th>{{translate('Quantity')}}</th>
                                                            <th>{{translate('Price')}}</th>
                                                            <th>{{translate('Tax')}}</th>

                                                        </tr>
                                                    </thead>


                                                    <tbody>


                                                        @foreach ($real->orderDetails as $index=>$product)

                                                        <tr>
                                                            <th>{{ $index + 1  }}</th>
                                                            <th>
                                                                {{ lang($product->product->id,Session::get('locale')) }}
                                                            </th>
                                                            <th>{{ $product->quantity }}</th>
                                                            <th>{{ $product->price }}</th>
                                                            <th>{{ $product->tax }}</th>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>


                                            </ul>
                                            @endforeach
                                            <hr>
                                        </th>
                                        <th> {{ route('getUserSendCart', $order->token) }} </th>

                                        <th>
                                            <table class="example table table-bordered">


                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ translate('Name') }}</th>
                                                        <th>{{translate('Quantity')}}</th>
                                                        <th>{{translate('Price')}}</th>
                                                        <th>{{translate('Tax')}}</th>

                                                    </tr>
                                                </thead>


                                                <tbody>

                                                    @php
                                                    $products = \App\Sendcartuser::where('order_id', '=',
                                                    $order->id)->get();
                                                    @endphp
                                                    @foreach ($products as $index=>$product)

                                                    <tr>
                                                        <th>{{ $index + 1  }}</th>
                                                        <th>
                                                            {{ lang($product->product->id,Session::get('locale')) }}
                                                        </th>
                                                        <th>{{ $product->quantity }}</th>
                                                        <th>{{ $product->price }}</th>
                                                        <th>{{ $product->tax }}</th>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </th>
                                        <th>{{  date("Y-m-d", strtotime($order->created_at)) }}</th>
                                        <th>{{ $order->total }}</th>
                                        <th>
                                            @php

                                            $option = App\AffiliateOption::where('type', '=',
                                            'product_sharing')->first();

                                            $comisstion = $option->percentage;

                                            $balance = $order->total / $comisstion;
                                            @endphp

                                            {{  $balance }}

                                        </th>
                                        <th> <a href="{{ route('affiliate.getsingleorder', $order->id) }}"> <span
                                                    class="btn btn-info"> <i class="fa fa-eye"></i> </span> </a></th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>






                <div class="col-md-12">
                    <div class="card">


                        <div class="card-body">
                            <table class="example table table-sm table-responsive-md mb-0 table-bordered">


                                <thead>
                                    <tr>
                                        <th> اسم المنتج</th>
                                        <th> العدد</th>


                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($productscount as $counts)
                                    <tr>
                                        <th>{{ $counts->name}}</th>
                                        <th>{{ $counts->count}}</th>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>



            </div>
        </div>
    </div>
</section>


@endsection



@section('script')

<script>
    $("#print-code").on('click', function () {


        var divToPrint=document.getElementById('bar-code');

        var newWin=window.open('','Print-Window');

        newWin.document.open();

        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

        newWin.document.close();

        setTimeout(function(){newWin.close();},10);

    });

    function showCheckoutModal(){
        $('#GuestCheckout').modal();
    }
</script>


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"> </script>

<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {

        $('.example').DataTable( {
            "order": [[ 1, "desc" ]],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf'
            ]
        } );
    });
</script>


@endsection