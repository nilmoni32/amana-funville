@extends('admin.app')
@section('title','Dashboard')
@section('content')
<div class="app-title">
  <div>
    <h1><i class="fa fa-dashboard"></i>&nbsp;Dashboard</h1>
  </div>
</div>
<div class="row">
  <div class="col-md-6 col-lg-3">
    <div class="widget-small primary coloured-icon">
      <i class="icon fa fa-users fa-3x"></i>
      <div class="info">
        <h4>Admin Users</h4>
        <p><b>( {{ App\Models\Admin::count()}} )</b></p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="widget-small info coloured-icon">
      <i class="icon fa fa-shopping-basket fa-3x"></i>
      <div class="info">
        <h4>Orders</h4>
        <p><b>( {{ App\Models\Order::count() + App\Models\Ordersale::count() }} )</b></p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="widget-small warning coloured-icon">
      <i class="icon fa fa-cutlery fa-3x"></i>
      <div class="info">
        <h4>Foods</h4>
        <p><b>({{ App\Models\Product::count() }})</b></p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="widget-small danger coloured-icon">
      <i class="icon fa fa-star fa-3x"></i>
      <div class="info">
        <h4>Ingredients</h4>
        <p><b>({{ App\Models\Ingredient::count() }})</b></p>
      </div>
    </div>
  </div>
</div>
@endsection