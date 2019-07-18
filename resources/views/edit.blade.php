@extends('dashboard')
@section('content')
    @if(\Illuminate\Support\Facades\Auth::user()->role==1)
        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary" style="text-align:center">
                                    <h4 class="card-title">Edit User</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{route('postEdit',['id'=>$user->id])}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <label for="profile_image" class="col-md-4 col-form-label text-md-right">Profile
                                                Image</label>
                                            <div class="col-md-6">
                                                <input id="profile_image" type="file" class="form-control"
                                                       name="profile_image">
                                                @if(\App\User::find($user->id)->profile_image)
                                                    <img src="{{asset(\App\User::find($user->id)->profile_image)}}"
                                                         style="width: 100px; height: 100px; border-radius:20px">
                                                @else
                                                    <img src="{{asset('img/img.png')}}"
                                                         style="width: 100px; height: 100px; border-radius:20px">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Username</label>
                                                    <input type="text" class="form-control" name="name"
                                                           value={{$user->name}}>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Email address</label>
                                                    <input type="email" class="form-control" name="email"
                                                           value={{$user->email}}>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Role</label>
                                                    <select type="text" class="form-control" name="role">
                                                        <option value="{{$user->role}}">
                                                            @if($user->role==1)
                                                                Admin
                                                            @else
                                                                User
                                                            @endif
                                                        </option>
                                                        <option value=1>Admin</option>
                                                        <option value=2>User</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="bmd-label-floating">Status</label>
                                                    <select type="text" class="form-control" name="active_flg">
                                                        <option value="{{$user->active_flg}}">
                                                            @if($user->active_flg==1)
                                                                Online
                                                            @else
                                                                Offline
                                                            @endif
                                                        </option>
                                                        <option value=1>Online</option>
                                                        <option value=2>Offline</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding-left:45%">
                                            <button type="submit" class="btn btn-primary pull-right" onclick="return confirm('Are you sure?')">Edit User</button>
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
    @endif
@endsection

