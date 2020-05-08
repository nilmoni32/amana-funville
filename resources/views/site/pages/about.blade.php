@extends('site.app')
@section('title', 'Homepage')
@section('content')
<!-- Breadcrumb Start -->
<div class="bread-crumb">
    <div class="container">
        <div class="matter">
            <h2>Food Menu</h2>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="{{ route('index')}}">HOME</a></li>
                <li class="list-inline-item"><a href="#">Food Menu</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
<div class="container py-5">
    <h3>About page</h3>
    dd({{url('/')}});
</div>

@endsection