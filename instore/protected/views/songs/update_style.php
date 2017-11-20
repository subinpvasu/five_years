<?php
/* @var $this SongsController */
/* @var $model Songs */
?>
<div id="main">
	<div class="main-holder">
		<div class="container_12">
			<div class="grid_12 main-frame2">
				<div id="login_overlay" style="display: block;">
					<div id="form_holder" style="overflow-x:hidden;overflow-y:scroll;height: 80%;top:5%;">
						<div class="page-ttl">
							<strong class="sub-ttl">Choose styles for selected songs</strong>
							<form method="post" action="" id="loginform" name="loginform">
								<?php 
								$song_styles = array();
								$str_remove = array('{','}');
								//$current_styles = explode(',',str_replace($str_remove,'',$model->style));
								?>
								<?php
								foreach($styles as $style): 
								?>
								<div class="tags_checkbox">
								<input type="checkbox" name="Songs[styles][]" value="<?=$style->id?>" ><?=$style->name?><br>
								</div>
								<input type="hidden" name="Songs[hidden]" value="1">
								
								<?php 
								endforeach;
								?>
								<br />
		
								<div class="submit">
									<div onclick="$('#loginform').submit();" id="submit">Tag</div>
									<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=songs/admin" ><div class="cancel">Cancel</div></a>
									<div style="clear: both"></div>
								</div>
								<input type="submit" style="display: none">
								
							</form>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
					<!-- #FORM_HOLDER -->
				</div>
				
			</div>
		</div>
	</div>
</div>
<style>
	.tags_checkbox {
	float: left;
    width: 50%;
    font-size: 16px;
    margin-bottom: 10px;
	}
	.inner #main .page-ttl {
	border-bottom:none;
	padding: 14px 14px 14px;
	}
	a {
    color: #DA6C0B;
    text-decoration: none;
	}
	div#login_overlay div#form_holder .submit {
    padding: 20px 0;
	position: inherit;
	width: 100%;
	margin-left: 32%;
	float: left;
	}
	div#login_overlay div#form_holder {
	width: 40%;
	position: absolute;
	left: 27%;
	top: 10%;
	margin: auto;
	background: #FFF;
	padding: 30px;
	text-align: left;
	}
</style>