@extends('vh::master')
@section('start_css')
    <link rel="stylesheet" type="text/css" href="{'assets/plugins/pg-calendar/css/pignose.calendar.min.css'}">
    <link rel="stylesheet" href="{'assets/promotion/flashsale/css/style.css'}">
    <link rel="stylesheet" href="{'assets/promotion/flashsale/css/base.css'}">
@endsection
@section('css')
    <link rel="stylesheet" href="{'assets/css/Checkbox.css'}">
    @yield('tp_css')
@endsection
@section('content')
    @yield('tp_main')
@endsection
@section('js')
    <script src="{'assets/js/ValidateForm.js'}" defer></script>
    <script src="{'assets/js/XHR.js'}" defer></script>
    <script src="{'assets/js/Storage.js'}" defer></script>
    <script src="{'assets/js/Checkbox.js'}" defer></script>
    <script src="{'assets/js/FormData.js'}" defer></script>
    <script src="{'assets/plugins/moment/moment.min.js'}" defer></script>
    <script src="{'assets/plugins/pg-calendar/js/pignose.calendar.full.min.js'}" defer></script>
    <script src="{'assets/plugins/sweetalert2/sweetalert2.js'}"></script>
    <script src="{'assets/promotion/flashsale/js/flashsale.js'}" defer></script>
@endsection
