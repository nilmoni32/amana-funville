@extends('admin.app')

@section('title')
{{-- Getting $pageTitle from BaseController setPageTitle()--}}
{{ $pageTitle }}
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i>&nbsp;{{ $pageTitle }}</h1>
        <p>{{ $subTitle }}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row mb-4">
                    <div class="col-12 pt-3">
                        <form action="{{ route('admin.reports.singleSale') }}" method="post"
                            class="form-inline justify-content-center">
                            @csrf
                            <div class="form-group mb-2">
                                <label>
                                    <span class="font-weight-bold pr-1">Choose Start Date :</span>
                                    <input type="date" name="start_date" value="<?php echo date('Y-m-d'); ?>" required>
                                </label>
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label class="font-bold">
                                    <span class="font-weight-bold pr-1">Choose End Date :</span>
                                    <input type="date" name="end_date" value="<?php echo date('Y-m-d'); ?>" required>
                                </label>
                            </div>
                            <div class="form-group mb-2">
                                {{-- <label><span class="font-weight-bold pr-1">Food Name
                                        <input type="text" name="food_search" class="form-control-plaintext"
                                            id="food_search" value="" required>
                                </label> --}}
                                <label>
                                    <span class="font-weight-bold pr-1">Food Name :</span>
                                    <input class="mr-3" type="text" name="search_food" value=""
                                        placeholder="Enter food name" required>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2" name="top20btn">
                                Item sale details</button>
                        </form>
                    </div>

                </div>
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th class="text-center"> # </th>
                            <th class="text-center"> Date </th>
                            <th class="text-center"> Food Name </th>
                            <th class="text-center"> Unit Price </th>
                            <th class="text-center"> Total Qty </th>
                            <th class="text-center"> Subtotal </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach($zones as $area)
                        <tr>
                            <td class="text-center" style="padding: 0.3rem; vertical-align: 0 ;">{{ $area->id }}
                        </td>
                        <td class="text-center" style="padding: 0.3rem; vertical-align: 0 ;">{{ $area->name }}
                        </td>
                        <td class="text-center" style="padding: 0.3rem; vertical-align: 0 ;">
                            <input type="checkbox" data-toggle="toggle" data-on="Active" data-off="Inactive"
                                {{ $area->status ? 'checked' : ''}} data-onstyle="primary" data-offstyle="secondary"
                                data-id={{$area->id}} class="districtStatus">
                        </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection