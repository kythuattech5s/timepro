@extends('index')
@section('main')
    <form action="{{\VRoute::get("register")}}" method="post" accept-charset="utf8">
        @csrf
        <input type="text" name="name" placeholder="Họ và tên">
        <input type="text" name="email" placeholder="Nhập email của bạn">
        <input type="text" name="phone" placeholder="Nhập số điện thoại của bạn">
        <input type="password" name="password" placeholder="Nhập mật khẩu">
        <input type="password" name="password_confirmation" placeholder="Xác nhận lại mật khẩu">
        <button type="submit">Đăng ký</button>
    </form>
@endsection