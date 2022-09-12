@extends('mail_templates.main_templete')
@section('content')
<div style="text-align:center">
    <p style="font-size:20px">Bạn hoặc ai đó đã gửi yêu cầu lấy lại mật khẩu</p>
    <p><a style="background: #AF1F26;color:white;text-decoration: none;display:inline-block;padding:10px 25px;font-size: 18px;border-radius: 5px;" href="{{$url}}"> Click vào đây</a></p>
    <p style="font-size:20px">Để lấy lại mật khẩu</p>
</div>
@endsection