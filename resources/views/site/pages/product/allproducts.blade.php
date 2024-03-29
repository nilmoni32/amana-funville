@extends('site.app')
@section('title', 'Food Menu')
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

<!-- Food Menu Start -->
<div class="shop pb-5">
    <div class="container py-3">
        <div class="row">
            <div class="col-md-3 px-0">
                <!-- Left search Filter and Category Start -->
                <div class="left-side">
                    <h4>{{ __('Funville Cuisine')}}</h4>
                    <div class="search mt-3 px-3 pb-0">
                        <form action="{{ route('search') }}" class="form-horizontal search-icon" method='get'>
                            <div class="form-group">
                                <input name="search" value="" class="form-control" placeholder="Search Food"
                                    type="text">
                                <button type="submit" value="submit" class="btn"><i
                                        class="icofont icofont-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="list-group list-group-flush mt-0 mb-5 hidden-xs">
                        <a href="{{ route('categoryproduct.show', 'all' ) }}"
                            class="list-group-item list-group-item-action active">
                            <img src="{{ asset('frontend')}}/images/dishes/all.jpg" width="60"
                                style="margin-right:15px;"><span>{{__('All Dishes')}}</span>
                        </a>
                        @foreach (App\Models\Category::orderBy('id', 'desc')->where('parent_id', '1')->where('menu', '1')->get() as
                        $parent)
                        <a href="{{ route('categoryproduct.show', $parent->slug ) }}"
                            class="list-group-item list-group-item-action">
                            <img src="{!! asset('storage/'.$parent->image) !!}" width="60"
                                style="margin-right:15px;"><span>{{ substr($parent->category_name, 0, 22) }}</span>
                        </a>
                        @endforeach
                    </div>

                </div>
                <!-- Left search Filter and Category End -->
            </div>
            <div class="col-md-9 pl-4">
                <!-- Title Content Start -->
                <div class="col-sm-12 commontop text-center mb-5">
                    <h4 class="mt-0">All Dishes</h4>
                    <div class="divider style-1 center">
                        <span class="hr-simple left"></span>
                        <i class="icofont icofont-ui-press hr-icon"></i>
                        <span class="hr-simple right"></span>
                    </div>
                </div>
                <!-- Title Content End -->
                @include('site.partials.productview')
            </div>
        </div>

    </div>
</div>
<!-- Shop End -->
@endsection