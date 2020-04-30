@extends('site.app')
@section('title', 'Register')
@section('content')
<!-- Breadcrumb Start -->
<div class="bread-crumb">
    <div class="container">
        <div class="matter">
            <h2>Sign up</h2>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="index.html">HOME</a></li>
                <li class="list-inline-item"><a href="#">Sign up</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
<!-- adding session messages -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 mt-5 text-center">
            @if (session('error'))
            <div class="alert alert-error alert-block bg-danger text-white">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ session('error') }}</strong>
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success alert-block bg-success text-white">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ session('success') }}</strong>
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Login Start -->
<div class="login">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 commontop text-center">
                <h4>Create an Account</h4>
                <div class="divider style-1 center">
                    <span class="hr-simple left"></span>
                    <i class="icofont icofont-ui-press hr-icon"></i>
                    <span class="hr-simple right"></span>
                </div>
            </div>
            <div class="col-lg-10 col-md-12">
                <div class="row justify-content-center mt-5">
                    <div class="col-sm-12 col-md-6">
                        <div class="loginnow">
                            <h5>Register</h5>
                            <p>Do You have an account? So <a href="{{ route('login') }}">login</a> And starts less than
                                a minute.</p>
                            <form action="{{ route('register') }}" method="post" role="form">
                                @csrf
                                <div class="form-group">
                                    <i class="icofont icofont-ui-user"></i>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ old('name') }}" placeholder="Your Name" required
                                        autocomplete="name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <i class="icofont icofont-stock-mobile"></i>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                        name="mobile" value="{{ old('mobile') }}" placeholder="Mobile No" id="mobile"
                                        required autocomplete="mobile" />
                                    @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <i class="icofont icofont-ui-message"></i>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="E-Mail Address" id="email"
                                        required autocomplete="email" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <i class="icofont icofont-lock"></i>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" value="{{ old('password') }}" placeholder="Password"
                                        id="password" required autocomplete="new-password" />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <i class="icofont icofont-lock"></i>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" placeholder="Confirm Password"
                                        id="password_confirmation" required autocomplete="new-password" />
                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="SIGN UP"
                                        class="btn btn-theme btn-md btn-block mt-5 mb-5" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register End -->
@stop