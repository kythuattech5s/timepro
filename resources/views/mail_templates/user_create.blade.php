@extends('mail_templates.main_template')
@section('content')
<p style="text-align: center">Tạo tài khoản thành công</p>
<div style="background: #f9f9f9; padding: 5px; text-align: center; color: #107849;">
    <a href="{{ $link }}" style="text-align: center; display:block">Kích hoạt tài khỏa ngay</a>
</div>
@endsection