<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ad-dukkan</title>
    <meta http-equiv="Content-Type" content="text/html;" />
    <meta charset="UTF-8">
    <style media="all">
        @font-face {
            font-family: 'Roboto';
            src: url("{{ my_asset('fonts/Roboto-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            line-height: 1.3;
            font-family: 'Roboto';
            color: #333542;
        }

        body {
            font-size: .875rem;
        }

        .gry-color *,
        .gry-color {
            color: #878f9c;
        }

        table {
            width: 100%;
        }

        table th {
            font-weight: normal;
        }

        table.padding th {
            padding: .5rem .7rem;
        }

        table.padding td {
            padding: .7rem;
        }

        table.sm-padding td {
            padding: .2rem .7rem;
        }

        .border-bottom td,
        .border-bottom th {
            border-bottom: 1px solid #eceff4;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .small {
            font-size: .85rem;
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

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div>

        @php
        $generalsetting = \App\GeneralSetting::first();
        @endphp

        <div style="background: #eceff4;padding: 1.5rem;">
            <table>
                <tr>
                    <td>
                        @if($generalsetting->logo != null)
                        <img loading="lazy" src="{{ my_asset($generalsetting->logo) }}" height="40"
                            style="display:inline-block;">
                        @else
                        <img loading="lazy" src="{{ my_asset('frontend/images/logo/logo.png') }}" height="40"
                            style="display:inline-block;">
                        @endif
                    </td>
                    <td style="font-size: 2.5rem;" class="text-right strong">Orders PDF </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td style="font-size: 1.2rem;" class="strong">{{ $generalsetting->site_name }}</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td class="gry-color small">{{ $generalsetting->address }}</td>
                    <td class="text-right"></td>
                </tr>
                <tr>
                    <td class="gry-color small">{{  translate('Email') }}: {{ $generalsetting->email }}</td>
                </tr>
                <tr>
                    <td class="gry-color small">{{  translate('Phone') }}: {{ $generalsetting->phone }}</td>
                </tr>
            </table>

        </div>



        <?php $id_css=0; ?>

        <div class="row">

            <div class="col-md-12">

                <div class="card no-border mt-5">

                    <div class="card-body cc">

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
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($orders as $order)

                                <tr>

                                    <th
                                        style="font-size: 398%;vertical-align: revert;text-align: center;background: #17a2b8;color: white;">
                                        {{ $order->id}}</th>

                                    <th>

                                        @php $reals = App\Order::where('token', '=',$order->token)->latest()->get();

                                        $id_css++; @endphp

                                        @foreach ($reals as $real)

                                        <ul class="main-ul">

                                            @php $delivery_status = $real->orderDetails->first()->delivery_status;

                                            @endphp

                                            <li style="display: grid;"> {{ $real->user->name }} </li>

                                            <li style="display: grid;"> {{ $real->user->email }} </li>

                                            <li style="

                                                display: grid;

                                            "> {{ $real->user->phone }} </li>



                                            <li> @if ($delivery_status == 'pending') <span class="label label-danger">

                                                    {{translate('Pending')}} </span>

                                                @endif

                                                @if ($delivery_status == 'on_review') <span class="label label-warning">
                                                    {{translate('On review')}} </span>

                                                @endif

                                                @if ($delivery_status == 'on_delivery') <span class="label label-info">
                                                    {{translate('On delivery')}} </span>

                                                @endif

                                                @if ($delivery_status == 'delivered') <span
                                                    class=" label label-success"> {{translate('Delivered')}} </span>

                                                @endif

                                            </li>

                                            <hr>

                                            <table class="table table-bordered">

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
                                                        <th> {{ lang($product->product->id,Session::get('locale')) }}</th>
                                                        <th>{{ $product->quantity }}</th>
                                                        <th>{{ $product->price }}</th>
                                                        <th>{{ $product->tax }}</th>

                                                    </tr>

                                                    @endforeach

                                                </tbody>

                                            </table>

                    </div>

                    </ul>

                    @endforeach

                    <hr>

                    </th>

                    <th>{{ route('getUserSendCart', $order->token) }}</th>

                    <th>

                        <table class="sss">

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



  @php $products = \App\Sendcartuser::where('order_id', '=',$order->id)->get(); @endphp

                                <ul class="list-group">

                                    <li class="list-group-item">الاسم :{{$products[0]->name}}</li>

                                    <li class="list-group-item"> الموبيل:{{$products[0]->pas}}</li>

                                    <li class="list-group-item"> البريد الالكتروني:{{$products[0]->email}}</li>

                                    <li class="list-group-item">

                            <tbody>

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

                            </li>

                            </ul>
                            <tr>
                            </tr>



                            </tbody>

                        </table>



                        <div id="demo{{ $id_css   }}" class="collapse">



                        </div>

                    </th>

 <th style="vertical-align: revert;text-align: center;">{{  $order->created_at }}</th>

                    <th style="vertical-align: revert;text-align: center;">{{ $order->total }}</th>

                    <th style="vertical-align: revert;text-align: center;">

                        @php



  $option = App\AffiliateOption::where('type', '=','product_sharing')->first();


                        $comisstion = $option->percentage;

                        $balance = $order->total / $comisstion;

                        @endphp



                        {{  $balance }}



                    </th>


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
                                <th>{{ lang($counts->name,Session::get('locale')) }}</th>
                                <th>{{ $counts->id}} </th>
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




    @section('script')



    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"> </script>



    <script>
        $(document).ready(function () {



            $('.example').DataTable({

                "order": [
                    [0, "desc"]
                ],

                dom: 'Bfrtip',

                buttons: [

                    'copy', 'csv', 'excel', 'pdf'

                ]

            });

        });

    </script>





</body>

</html>
