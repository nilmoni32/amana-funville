@extends('site.app')
@section('title', 'User Dashboard')
@section('content')
<!-- Breadcrumb Start -->
<div class="bread-crumb">
    <div class="container">
        <div class="matter">
            <h2>Your Profile</h2>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="{{ route('index')}}">HOME</a></li>
                <li class="list-inline-item"><a href="#">Your Profile</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->
<!-- adding session messages -->
<div class="container">

</div>
<!-- User Profile Start -->
<div class="dashboard pb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 commontop text-center">
                <h4>Your Profile</h4>
                <div class="divider style-1 center">
                    <span class="hr-simple left"></span>
                    <i class="icofont icofont-ui-press hr-icon"></i>
                    <span class="hr-simple right"></span>
                </div>
            </div>

            <div class="col-md-6 col-sm-12 text-center">
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

            <div class="col-lg-12 col-md-12 user-profile">
                <div class="row">
                    <div class="col-md-4 col-lg-2">
                        <div class="user-profile-tabs">
                            <!--  Menu Tabs Start  -->
                            <ul class="nav nav-tabs flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#profile" aria-expanded="true">
                                        <i class="icofont icofont-ui-user"></i>
                                        <span>Update Profile</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#password" aria-expanded="true">
                                        <i class="icofont icofont-ui-password"></i>
                                        <span>Change Password</span>
                                    </a>
                                </li>
                            </ul>
                            <!--  Menu Tabs Start  -->
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-9">
                        <div class="tab-content">
                            <div id="profile" class="tab-pane fade active show">
                                <div class="user-personal-info">
                                    <h5>Personal Information</h5>
                                    <div class="user-info-body">
                                        <form action="{{ route('user.updateProfile') }}" method="post" role="form">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" id="name" value="{{ $user->name }}"
                                                        placeholder="Your Name" required autocomplete="name">
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        name="email" value="{{ $user->email }}"
                                                        placeholder="E-Mail Address" id="email" required
                                                        autocomplete="email" {{ $user->is_email_verified ? 'disabled':
                                                    '' }} />
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <input type="text"
                                                        class="form-control @error('mobile') is-invalid @enderror"
                                                        name="mobile" value="{{ $user->mobile }}"
                                                        placeholder="Mobile No" id="mobile" required
                                                        autocomplete="mobile" {{ $user->is_mobile_verified ? 'disabled':
                                                        '' }} />
                                                    @error('mobile')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <textarea placeholder="Your Contact Address" id="current-address"
                                                        class="form-control" rows="4"
                                                        name="address">{{ $user->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group mb-0 pt-4 col-12 text-center">
                                                    <button class="btn btn-theme btn-md" type="submit">SAVE
                                                        CHANGES</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="password" class="tab-pane fade">
                                <div class="user-change-password">
                                    <h5>Change Password</h5>
                                    <div class="change-password-body">
                                        <form action="{{ route('user.changePassword') }}" method="post" role="form">
                                            @csrf
                                            <div class="form-group">
                                                <input type="password"
                                                    class="form-control @error('old-password') is-invalid @enderror"
                                                    name="old_password" placeholder="Old Password" id="old-password"
                                                    required>
                                                @error('old-password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" value="{{ old('password') }}"
                                                    placeholder="New Password" id="password" required
                                                    autocomplete="new-password" />
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
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
                                            <div class="form-group mb-0 pt-4 text-center">
                                                <button class="btn btn-theme btn-md" type="submit">SAVE CHANGES</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection