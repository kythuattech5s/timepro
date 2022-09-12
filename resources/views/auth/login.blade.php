@extends('index')
@section('main')
    <form action="{{\VRoute::get("login")}}" class="formValidation" method="post" absolute data-success="NOTIFICATION.toastrMessageRedirect" accept-charset="utf8">
        @csrf
        <input type="text" name="username" placeholder="Nhập email hoặc số điện thoại" rules="required||email">
        <input type="password" name="password" placeholder="Nhập mật khẩu" rules="required">
        <button type="submit">Đăng nhập</button>
    </form>
@endsection