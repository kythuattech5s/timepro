@extends('vh::master')
@section('content')
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" type="text/css" href="{'tech5sMarketing/css/marketing/base.css'}">
	@yield('css')
	@yield('main')
@endsection
@section('js')
	<link rel="stylesheet" type="text/css" href="{'tech5sMarketing/css/m-checkbox.css'}">
	<script src="{'tech5sMarketing/js/storage.js'}" defer></script>
	<script src="{'tech5sMarketing/js/xhr.js'}" defer></script>
	<script src="{'tech5sMarketing/js/load-more.js'}" defer></script>
	<script src="{'tech5sMarketing/js/validateForm.js'}" defer></script>
	<script src="{'tech5sMarketing/js/filter.js'}" defer></script>
	<script src="{'tech5sMarketing/js/m-checkbox.js'}" defer></script>
	<script src="{'tech5sMarketing/js/promotion.js'}" defer></script>
	<script src="{'tech5sMarketing/js/voucher.js'}" defer></script>
	<script src="{'tech5sMarketing/js/deal.js'}" defer></script>
	<script src="{'tech5sMarketing/js/flash_sale.js'}" defer></script>
	<script src="{'tech5sMarketing/js/combo.js'}" defer></script>
	<script src="{'tech5sMarketing/js/promotion_product.js'}" defer></script>
	<script defer>
	 window.addEventListener('DOMContentLoaded', (event) => {
	  M_CHECKBOX.setConfig({
	   classGetCount: ['#modalProduct .count-choose', '.count-product-chooses']
	  });
	 })
	</script>
	@yield('js')
@endsection
