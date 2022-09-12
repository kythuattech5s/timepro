@extends('index')
@section('main')
    <form action="{{\VRoute::get("forgot-password")}}" method="post" accept-charset="utf8">
        @csrf
        <input type="text" name="email" placeholder="Nhập email của bạn">
        <button type="submit">Xác nhận</button>
    </form>
@endsection