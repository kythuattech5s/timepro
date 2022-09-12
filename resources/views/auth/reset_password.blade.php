@extends('index')
@section('main')
    <form action="{{\VRoute::get("reset-password")}}" method="POST" accept-charset="utf8">
        @csrf
        <input type="hidden" name="token" value="{{request()->token}}">
        <input type="password" name="password" placeholder="Mật khẩu">
        <input type="password" name="password_confirmation" placeholder="Xác nhận lại mật khẩu">
        <button type="submit">Xác nhận</button>
    </form>
@endsection