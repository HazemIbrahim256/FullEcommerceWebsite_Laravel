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
                        <h3 class="text-center"><span class="">Hi...</span><strong>{{Auth::user()->name}}</strong> Update your profile</h3>
                        <div class="card-body">
                            <form method="POST" action="{{route('user.profile.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Name <span> </span></label>
                                    <input type="text" class="form-control unicase-form-control text-input" name="name" value="{{$user->name}}">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Email Address <span> </span></label>
                                    <input type="email" class="form-control unicase-form-control text-input" name="email" value="{{$user->email}}">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Phone number <span> </span></label>
                                    <input type="text" class="form-control unicase-form-control text-input" name="phone" value="{{$user->phone}}">
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail1">Avatar <span> </span></label>
                                    <input type="file" class="form-control unicase-form-control text-input" name="profile_photo_path">
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