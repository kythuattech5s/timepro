@extends('vh::master')
@section('start_css')
    <link rel="stylesheet" href="{'admin/promotion/css/app.css'}">
@endsection
@section('css')
	<link rel="stylesheet" type="text/css" href="{'admin/promotion/assets/css/base.css'}">
	<link rel="stylesheet" href="{'admin/promotion/assets/_rs/css/Checkbox.css'}">
	@yield('tp_css')
@endsection
@section('content')
	@yield('tp_main')
@endsection
@section('js')
	<script src="{'admin/promotion/assets/_rs/js/Helper.js'}" defer></script>
	<script src="{'admin/promotion/assets/_rs/js/ValidateForm.js'}" defer></script>
	<script src="{'admin/promotion/assets/_rs/js/XHR.js'}" defer></script>
	<script src="{'admin/promotion/assets/_rs/js/Storage.js'}" defer></script>
	<script src="{'admin/promotion/assets/_rs/js/Checkbox.js'}" defer></script>
	<script src="{'admin/promotion/assets/_rs/js/FormData.js'}" defer></script>
	@yield('tp_js')
@endsection
