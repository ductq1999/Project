@extends('dashboard')
@section('content')
    <div class="main-panel">
        <div class="content">
            <form method="get" action="{{route('search',['user'=>$user])}}" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="asterisk">Name</span>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Name"
                                           value="{{\Illuminate\Support\Facades\Session::get('name')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="asterisk">Role</span>
                            </div>
                            <div class="col-md-9">
                                <select name="role" class="form-control">
                                    <option value="{{\Illuminate\Support\Facades\Session::get('role')}}">
                                        @if(\Illuminate\Support\Facades\Session::get('role')==1)
                                            Admin
                                        @elseif(\Illuminate\Support\Facades\Session::get('role')==2)
                                            User
                                        @else
                                            All
                                        @endif
                                    </option>
                                    <option value=>All</option>
                                    <option value=1>Admin</option>
                                    <option value=2>User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="asterisk">Email</span>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="Email"
                                           value="{{\Illuminate\Support\Facades\Session::get('email')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-2">
                                <span class="asterisk">Status</span>
                            </div>
                            <div class="col-md-9">
                                <select name="active_flg" class="form-control">
                                    <option value="{{\Illuminate\Support\Facades\Session::get('active_flg')}}">
                                        @if(\Illuminate\Support\Facades\Session::get('active_flg')==1)
                                            Online
                                        @elseif(\Illuminate\Support\Facades\Session::get('active_flg')==2)
                                            Offline
                                        @else
                                            All
                                        @endif
                                    </option>
                                    <option value=>All</option>
                                    <option value=1>Online</option>
                                    <option value=0>Offline</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" style="background: #9c27b0; color: white">Search</button>
            </form>
            @if(\Illuminate\Support\Facades\Auth::user()->role==1)
                <button style="background:#A901DB"><a href="{{route('getAdd')}}" style="color: white">Add User</a>
                </button>
            @endif
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Simple Table</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class=" text-primary">
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Role
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Avatar
                                        </th>
                                        @if(\Illuminate\Support\Facades\Auth::user()->role==1)
                                            <th style="text-align: center">
                                                Action
                                            </th>
                                        @endif
                                        </thead>
                                        <tbody>
                                        @foreach($user  as $users)
                                            <tr>
                                                <td>
                                                    {{$users->name}}
                                                </td>
                                                <td>
                                                    {{$users->email}}
                                                </td>
                                                <td>
                                                    {{$users->role == 1?'Admin':'User'}}
                                                </td>
                                                <td>
                                                    {{$users->active_flg==1?'Online':'Offline'}}
                                                </td>
                                                <td>
                                                    @if($users->profile_image)
                                                        <img src="{{asset($users->profile_image)}}"
                                                             style="width: 100px; height: 100px; border-radius:20px">
                                                    @else
                                                        <img src="{{asset('img/img.png')}}"
                                                             style="width: 100px; height: 100px; border-radius:20px">
                                                    @endif
                                                </td>
                                                @if(\Illuminate\Support\Facades\Auth::user()->role==1)
                                                    <td class="text-primary" style="text-align: center">
                                                        <a href="{{route('getEdit',['id'=>$users->id])}}"><i
                                                                    class="fa fa-pencil"
                                                                    style="font-size:18px;color:blue" title="Edit"></i></a>
                                                        @if($users->id!=\Illuminate\Support\Facades\Auth::user()->id && $users->active_flg==1)
                                                            <a onclick="return confirm('Are you sure?')"
                                                               href="{{route('delete',['id'=>$users->id])}}"><i
                                                                        class="fa fa-trash"
                                                                        style="font-size:18px;color:red "
                                                                        title="Delete"></i></a>
                                                        @else
                                                            <i class="fa fa-trash"
                                                               style="font-size:18px;color:red; opacity: 0.3"
                                                               title="Delete"></i>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$user->links()}}
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


