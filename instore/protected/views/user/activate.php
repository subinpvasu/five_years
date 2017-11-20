<?php
/* @var $this UserController */
/* @var $model User */

?>
<style>
.errorSummary {
	background: none repeat scroll 0 0 #FFEEEE;
	border: 2px solid #CC0000;
	font-size: 0.9em;
	margin: 0 0 20px;
	padding: 7px 7px 12px;
}

.success {
	color: green;
}
</style>
<h1>Activate account</h1>
<?
if(isset($error) && $error != '')
{
	echo '<div class="errorSummary">'.$error.'</div>';
}
else
{
	echo '<div class="success">'.$msg.'</div>';
}
?>


