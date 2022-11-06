@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div class="row">
                @include('frontend.common.user_sidebar')

                <div class="col-md-2">

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h3 class="text-center"><span class=""><strong>Change Password</strong></span></h3>
                        <div class="card-body">
                            <form method="POST" action="{{route('user.password.update')}}">
                                @csrf
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Current Password <span> </span></label>
                                    <input type="password" id="current_password" class="form-control unicase-form-control text-input" name="oldpassword">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">New Password <span> </span></label>
                                    <input type="password" id="password" class="form-control unicase-form-control text-input" name="password">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Password Confirmation <span> </span></label>
                                    <input type="password" id="password_confirmation" class="form-control unicase-form-control text-input" name="password_confirmation">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection