<?php 
	$name = FCHelper::er($table,'name');
	$value ="";	
	if($actionType=='edit'||$actionType=='copy'){
		$value = FCHelper::er($dataItem,$name);
	}
?>
<script type="text/javascript">
	var baseurl = '{{url()->to('/')}}';
	var admincp = '{{$admincp}}';
</script>
@if ($actionType=='edit'||$actionType=='copy')
	<script type="text/javascript">
		var inEditQuestion = true;
	</script>
@endif
<link rel="stylesheet" href="managequestion/admin/base.css"/>
<div class="form-group">
  	<p class="form-title" for="">{{FCHelper::er($table,'note')}}<span class="count"></span></p>
  	<input type="hidden" id="question_content_value" value="{{$value}}">
  	<input type="hidden" id="question_content_name" value="{{$name}}">
 	<div id="question_content_result">
 		
 	</div>
</div>
<script type="text/javascript" src="managequestion/admin/element.js?v={{time()}}" defer></script>
<script type="text/javascript" src="managequestion/admin/base.js?v={{time()}}" defer></script>