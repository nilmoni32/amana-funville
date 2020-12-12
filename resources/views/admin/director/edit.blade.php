@extends("admin.app")
@section('title')
{{-- Getting $pageTitle from BaseController setPageTitle()--}}
{{ $pageTitle }}
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-ils"></i>&nbsp;{{ $pageTitle }}</h1>
        <p>{{ $subTitle }}</p>
    </div>
</div>
@include('admin.partials.flash')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
            <h3 class="tile-title text-center">{{$subTitle}}</h3>
            <form action=" {{ route('admin.board.directors.update') }} " method="POST" role="form">
                @csrf
                <div class="tile-body">
                    <input type="hidden" name="id" value="{{ $director->id }}">
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="name">Name<span class="text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ old('name', $director->name) }}" placeholder="Enter Name" required>
                            @error('name') {{ $message }}@enderror
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="mobile">Phone No<span class="text-danger">
                                    *</span></label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile"
                                id="mobile" value="{{ old('mobile', $director->mobile) }}" placeholder="Enter Phone No"
                                required>
                            @error('mobile') {{ $message }}@enderror
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email"
                                id="email" value="{{ old('email', $director->email) }}" placeholder="Enter email">
                            @error('email') {{ $message }}@enderror
                        </div>
                    </div>
                    <div class="col-md-8 mx-auto">
                        <div class="form-group">
                            <label class="control-label" for="designation">Position<span class="text-danger">
                                    *</span></label>
                            <input class="form-control @error('designation') is-invalid @enderror" type="text"
                                name="designation" id="designation"
                                value="{{ old('designation', $director->designation) }}" placeholder="Enter Postion"
                                required>
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
                                value="{{ old('discount_slab_percentage', $director->discount_slab_percentage ) }}"
                                placeholder="Enter discount slab percentage">
                            @error('discount_slab_percentage') {{ $message }}@enderror
                        </div>
                    </div>
                </div>
                <div class="tile-footer pb-5">
                    <div class="pull-right">
                        <button class="btn btn-primary" type="submit"><i
                                class="fa fa-fw fa-lg fa-check-circle"></i>Update
                            Details</button>
                        &nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="{{ route('admin.board.directors.index') }}"><i
                                class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection