@extends('vh::master')
@section('content')
    @if (isset($gaViewKey) && $gaViewKey !='')
        @include('vh::statistical_google_analytics')
    @else
        <p>Xin chào <strong>{{Auth::guard('h_users')->user()->name}}</strong></p>
    @endif
@stop