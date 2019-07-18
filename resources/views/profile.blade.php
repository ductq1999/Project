@extends('dashboard')
@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary" style="text-align:center">
                                <h4 class="card-title">User Profile</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{route('update',['user'=>$user])}}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Username</label>
                                                <input onchange="myFun()" type="text" class="form-control" name="name"
                                                       value="{{ $user->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Email address</label>
                                                <input type="email" class="form-control" name="email"
                                                       value="{{$user->email}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="bmd-label-floating">Role</label>
                                                <input type="text" class="form-control" name="role"
                                                       value="{{($user->role==1?'admin':'user')}}" disabled="true">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="profile_image" class="col-md-4 col-form-label text-md-right">Profile
                                                Image</label>
                                            <div class="col-md-6">
                                                <input id="profile_image" type="file" class="form-control"
                                                       name="profile_image">
                                                @if(\Illuminate\Support\Facades\Auth::user()->profile_image)
                                                <img src="{{asset(\Illuminate\Support\Facades\Auth::user()->profile_image)}}"
                                                     style="width: 100px; height: 100px; border-radius:20px">
                                                @else
                                                    <img src="{{asset('img/img.png')}}"
                                                         style="width: 100px; height: 100px; border-radius:20px">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-left:45%">
                                        <button type="submit" class="btn btn-primary pull-right" onclick="return confirm('Are you sure?')">Update Profile</button>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
