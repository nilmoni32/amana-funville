@extends('site.app')
@section('title', 'Reset Password')
@section('content')
<!-- Breadcrumb Start -->
<div class="bread-crumb">
    <div class="container">
        <div class="matter">
            <h2>Reset Password</h2>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="index.html">HOME</a></li>
                <li class="list-inline-item"><a href="#">Reset Password</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
<div class="container mb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8">
            <div class="card mb-5 mt-5">
                <div class="card-header"><strong>{{ __('Reset Password') }}</strong></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('postforgot') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <input type="submit" value="Send email" class="btn btn-theme btn-md btn-block"
                                    style="width:50%; font-weight:normal;" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection