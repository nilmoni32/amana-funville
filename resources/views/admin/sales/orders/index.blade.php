@extends('admin.app')

@section('title')
{{-- Getting $pageTitle from BaseController setPageTitle()--}}
{{ $pageTitle }}
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-database"></i>&nbsp;{{ $pageTitle }}</h1>
        <p>{{ $subTitle }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <form action="{{ route('admin.pos.orders.search') }}" method="get">
                    @csrf
                    <div class="row mb-3 mr-4">
                        <div class="app-search offset-xl-10 col-xl-2 offset-md-6 col-md-3 col-7">
                            <input class="app-search__input"
                                style="background:rgb(230, 230, 230); border: 1px solid rgb(201, 201, 201);"
                                type="search" placeholder="Search" name="search" />
                            <button type="submit" class="app-search__button" style="margin-right:-18px;">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th class="text-center"> Order No </th>
                            <th class="text-center"> Order Date</th>
                            <th class="text-center"> Order Table No</th>
                            <th class="text-center"> Paid Amount </th>
                            <th class="text-center"> Payment Type </th>
                            <th style=" min-width:50px;" class="text-center text-danger"><i class="fa fa-bolt"></i></th>
                            <th class="text-center">View Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="text-center" style="padding: 0.5rem; vertical-align: 0 ;">
                                {{ $order->order_number }}
                            </td>
                            <td class="text-center" style="padding: 0.5rem; vertical-align: 0 ;">
                                {{-- {{ $order->order_date }} --}}
                                {{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y H:i:s') }}
                            </td>
                            <td class="text-center" style="padding: 0.5rem; vertical-align: 0 ;">
                                {{ $order->order_tableNo }}
                            </td>
                            <td class="text-center" style="padding: 0.5rem; vertical-align: 0 ;">
                                {{ round($order->grand_total,0) }}
                            </td>
                            <td class="text-center" style="padding: 0.5rem; vertical-align: 0 ;">
                                {{ str_replace(',', ', ', $order->payment_method) }}
                            </td>
                            <td class="text-center" style="padding: 0.5rem; vertical-align: 0 ;">
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <a href="{{ route('admin.pos.orders.edit', $order->id) }}"
                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                </div>
                            </td>
                            <td class="text-center" style="padding: 0.5rem; vertical-align: 0 ;">
                                <div class="btn-group" role="group" aria-label="Second group">
                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#userCartModal{{ $order->id }}"><i
                                            class="fa fa-shopping-basket"></i></a>
                                    <!-- User Cart Modal -->
                                    {{-- @include('admin.orders.includes.userCart') --}}
                                    <a href="#" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#userBankModal{{ $order->id }}"><i class="fa fa-print"
                                            style="font-size:20px"></i></a>
                                    <!-- User Bank Transaction Modal -->
                                    {{-- @include('admin.orders.includes.userBank') --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="pt-4 text-right">
    {{ $orders->links() }}
</div>

@endsection
@push('scripts')
<script type="text/javascript">

</script>
@endpush