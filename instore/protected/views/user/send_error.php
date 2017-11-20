<?php 
/* @var $this CustomersController */
/* @var $model Customers */
?>

<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<strong class="sub-ttl" style="color: #DA6C0B;
			    display: block;
			    font: 22px 'BertholdAkzidenzGroteskBERegu',Arial,Helvetica,sans-serif;
			    z-index: auto;">Send error</strong>
				<div id="butn_renm"> Send</div>
				
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
<style>
#butn_renm {
    border: 1px solid #33CCCC;
    background-color: #d4d4d4;
    border-radius: 7px;
    float: left;
    height: 30px;
    margin-bottom: 5px;
    margin-left: 43%;
    margin-top: 7px;
    padding-top: 12px;
    text-align: center;
    width: 12%;
	cursor: pointer;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
	$('#butn_renm').on("click", null, function(){
	$.post("index.php?r=user/error_mail",{CUSTOM_DATA: "1045" , STACK_TRACE: "Error details",USER_CRASH_DATE: "20-09-1989"}, function(data){
						if(data.length >0) {
							alert(data);							
						}
					});
});
});
</script>