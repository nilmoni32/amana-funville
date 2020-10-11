@extends('admin.app')
@section('title')
{{-- Getting $pageTitle from BaseController setPageTitle()--}}
{{ $pageTitle }}
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-podcast"></i>&nbsp;{{$pageTitle}}</h1>
        <p>{{ $subTitle }}</p>
    </div>
</div>
@include('admin.partials.flash')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
            <h3 class="tile-title text-center">{{$subTitle}}</h3>
            <hr>
            <form action=" {{ route('admin.board.directors.store') }} " method="POST" role="form">
                @csrf
                <div class="tile-body">
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="name">Name<span class="text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ old('name') }}" placeholder="Enter Name" required>
                            @error('name') {{ $message }}@enderror
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="mobile">Phone No<span class="text-danger">
                                    *</span></label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile"
                                id="mobile" value="{{ old('mobile') }}" placeholder="Enter Phone No" required>
                            @error('mobile') {{ $message }}@enderror
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email"
                                id="email" value="{{ old('email') }}" placeholder="Enter email">
                            @error('email') {{ $message }}@enderror
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="designation">Position<span class="text-danger">
                                    *</span></label>
                            <input class="form-control @error('designation') is-invalid @enderror" type="text"
                                name="designation" id="designation" value="{{ old('designation') }}"
                                placeholder="Enter Postion" required>
                            @error('designation') {{ $message }}@enderror
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="discount_slab_percentage">Discount Slab Percentage
                                (%)<span class="text-danger">
                                    *</span></label>
                            <input class="form-control @error('discount_slab_percentage') is-invalid @enderror"
                                type="text" name="discount_slab_percentage" id="discount_slab_percentage"
                                value="{{ old('discount_slab_percentage') }}"
                                placeholder="Enter discount slab percentage">
                            @error('discount_slab_percentage') {{ $message }}@enderror
                        </div>
                    </div>
                </div>
                <div class="tile-footer pb-5">
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Add
                            Director</button>
                        &nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="{{ route('admin.board.directors.index') }}"><i
                                class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection