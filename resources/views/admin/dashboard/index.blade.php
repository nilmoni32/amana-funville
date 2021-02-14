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
      <i class="icon fa fa-delicious fa-3x"></i>
      <div class="info">
        <h5>Today KOT Sales</h5>
        <p><b>( {{ round(App\Models\Ordersale::whereDate('created_at', '=', Carbon\Carbon::today()->toDateString())->sum('grand_total'), 2)}} {{ config('settings.currency_symbol') }} )</b></p>
      </div>
    </div>
  </div>  
  <div class="col-md-6 col-lg-3">
    <div class="widget-small info coloured-icon">
      <i class="icon fa fa-shopping-basket fa-3x"></i>
      <div class="info">
        <h5>KOT Orders</h5>
        <p><b>( {{ App\Models\Ordersale::count() }} )</b></p>
      </div>
    </div>
  </div> 
  <div class="col-md-6 col-lg-3">
    <div class="widget-small warning coloured-icon">
      <i class="icon fa fa-users fa-3x"></i>
      <div class="info">
        <h5>Admin Users</h5>
        <p><b>( {{ App\Models\Admin::count()}} )</b></p>
      </div>
    </div>
  </div>
 <div class="col-md-6 col-lg-3">
  <div class="widget-small danger coloured-icon">
    <i class="icon fa fa-cutlery fa-3x"></i>
    <div class="info">
      <h4>Foods</h4>
      <p><b>({{ App\Models\Product::count() }})</b></p>
    </div>
  </div>
</div> 
</div>
<div class="row">
  <div class="col-md-6 col-lg-3">
    <div class="widget-small primary coloured-icon">
      <i class="icon fa fa-bar-chart fa-3x"></i>
      <div class="info">
        <h5>Today Online Sales</h5>
        <p><b>( {{ round(App\Models\Order::where('status', 'delivered')->whereDate('created_at', '=', Carbon\Carbon::today()->toDateString())->sum('grand_total'), 2)}} {{ config('settings.currency_symbol') }} )</b></p>
      </div>
    </div>
  </div>   
  <div class="col-md-6 col-lg-3">
    <div class="widget-small bg-info coloured-icon">
      <i class="icon fa fa-shopping-basket fa-3x"></i>
      <div class="info">
        <h5>Online Orders</h5>
        <p><b>( {{ App\Models\Order::count()  }} )</b></p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="widget-small bg-success coloured-icon">
      <i class="icon fa fa-users fa-3x"></i>
      <div class="info">
        <h5>Online Customers</h5>
        <p><b>( {{ App\Models\User::count()}} )</b></p>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-3">
    <div class="widget-small bg-danger coloured-icon">
      <i class="icon fa fa-star fa-3x"></i>
      <div class="info">
        <h5>Ingredients</h5>
        <p><b>({{ App\Models\Ingredient::count() }})</b></p>
      </div>
    </div>
  </div>
</div>
@endsection