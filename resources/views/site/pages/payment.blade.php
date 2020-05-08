@extends('site.app')
@section('title', 'Checkout')
@section('content')
<!-- Breadcrumb Start -->
<div class="bread-crumb">
    <div class="container">
        <div class="matter">
            <h2>Checkout</h2>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="{{ route('index')}}">HOME</a></li>
                <li class="list-inline-item"><a href="#">Checkout</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
<div class="mycart">
    <div class="container paycard">
        <div class="row">
            <div class="offset-md-2"></div>
            <div class="col-md-8 col-12 mb-5 text-center">
                @if (session('success'))
                <div class="alert alert-success alert-block bg-success text-white">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-error alert-block bg-danger text-white">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('error') }}</strong>
                </div>
                @endif
            </div>
            <div class="offset-md-2"></div>
        </div>
        <div class="row">
            <div class="col-12 pb-5">
                <h5 class="card-title mt-2 text-center mb-2">Order Number:
                    {{ $order->order_number }}</h5>
                <p class="text-center pt-0 font-weight-bold">Your order is on its way, please pay <a
                        href="{{ route('checkout.cash', $order->id) }}" class="btn btn-theme-alt"
                        style="width:100px; height:30px; padding:0; font-weight:normal; text-transform:capitalize; line-height:1.6rem ">
                        with
                        cash</a> on delivery
                    orders.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="offset-md-2"></div>
            <div class="col-md-8 col-12 mb-5">
                <div class="card">
                    <p class="text-center py-3">Do you want to <span class="text-success font-weight-bold h5">pay
                            now?</span></p>
                    <div class="card-body px-5">
                        <ul class="list-inline text-center link pb-4">
                            <li class="list-inline-item">
                                <small>Bangladeshi credit/debit card</small><br>
                                <a href="{{ route('order.payment', $order->id) }}" class="btn btn-theme-alt my-2"
                                    role="button"><img src="{{ asset('frontend')}}/images/payment.png" alt="visa"
                                        title="Bangladeshi credit/debit card" class="img-fluid" width="130px">
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <small>Mobile Banking</small><br>
                                <a href="#" class="btn btn-theme-alt my-2" role="button"><img
                                        src="{{ asset('frontend')}}/images/bkash.png" alt="master" title="bCash"
                                        class="img-fluid" width="90px"></a>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="offset-md-2"></div>
        </div>
        <div class="row">
            <div class="offset-md-2"></div>
            <div class="col-md-8 col-12 mb-5">
                <div class="row">
                    <div class="col-md-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header text-center">
                                Delivery Date & Address
                            </div>
                            <div class="card-body text-center">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>{{ $order->address }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                            $time = strtotime($order->order_date);
                                            $date = date('Y-m-d', $time); @endphp
                                            <td class="text-center">Order Date: <span class="ml-5">{{ $date }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            @php
                                            $time = strtotime($order->delivery_date);
                                            $date = date('Y-m-d', $time); @endphp
                                            <td class="text-center">Delivery Date: <span class="ml-5">{{ $date }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 mb-3">
                        <div class="card">
                            <div class="card-header text-center">
                                Order Summary
                            </div>
                            <div class="card-body text-center">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-left">Subtotal</td>
                                            <td class="text-left">{{ config('settings.currency_symbol') }}
                                                {{  round(($order->grand_total - config('settings.delivery_charge')),0) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">shipping</td>
                                            <td class="text-left">{{ config('settings.currency_symbol') }}
                                                {{  config('settings.delivery_charge') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left">Order Total</td>
                                            <td class="text-left">{{ config('settings.currency_symbol') }}
                                                {{  round($order->grand_total,0) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offset-md-2"></div>
        </div>
        <div class="row pt-2 mb-4">
            <div class="col-sm-12 col-xs-12">
                <div class="text-center pb-2">
                    <a class="btn btn-theme-alt btn-wide" href="{{ route('checkout.cancel', $order->id) }}">Cancel
                        Order</a>
                </div>
            </div>
        </div>




    </div>
</div>

@endsection