<div>name:{{$name}}</div>
<div>email:{{$email}}</div>
<div>password:{{$password}}</div>
<div>role:{{$role==2?'user':'admin'}}</div>
<div>status:{{$active_flg==1?'online':'offline'}}</div>
@foreach($data as $user)
@if($name==$user->name)
    <div style="color: red">Username da ton tai</div>
@endif
@if($email==$user->email)
    <div style="color: red">Email da ton tai</div>
@endif
@endforeach