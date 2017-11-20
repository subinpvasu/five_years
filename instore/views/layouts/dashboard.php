<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html
	xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<?php /*
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />

<!-- blueprint CSS framework -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
<![endif]-->

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	*/?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<!---  New template code --->
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link type="text/css" rel="stylesheet"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/dd.css" />
<link type="text/css" rel="stylesheet"
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"
	media="all" />
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
<script
	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui-1.8.6.custom.min.js"
	type="text/javascript"></script>
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jQuery.jPlayer/jquery.jplayer.min.js"></script>

<script
	src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mums.js"
	type="text/javascript"></script>
<script
	src="<?php echo Yii::app()->request->baseUrl; ?>/js/input-file.js"
	type="text/javascript"></script>
<script
	src="<?php echo Yii::app()->request->baseUrl; ?>/js/slideblock.js"
	type="text/javascript"></script>
<script
	type="<?php echo Yii::app()->request->baseUrl; ?>/text/javascript"
	src="js/jquery-plugins/MSDropDown/jquery.dd.js"></script>
<script
	type="<?php echo Yii::app()->request->baseUrl; ?>/text/javascript"
	src="js/jquery-plugins/MSDropDown/jquery.dropdownPlain.js"></script>
<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/source/jquery.fancybox.css?v=2.1.5"
	media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->request->baseUrl; ?>/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<!-- Add Media helper (this is optional) -->
<script type="text/javascript"
	src="<?php echo Yii::app()->request->baseUrl; ?>/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
</head>

<body>
	<script type="text/javascript">
		$(document).ready(function() {
			$(".fancybox").fancybox();
		});
	</script>
	<script type="text/javascript">        
        var bPlaying = false;
        
        function PlayDemo()
        {
            if (!bPlaying)
            {
                $('#player_container').jPlayer('play', 0);
                bPlaying = true;
            } else {    
                $('#player_container').jPlayer('pause');
                bPlaying = false;
              }
            
            return true;
        }

        $(function() {
            $('#player_container').jPlayer({
                 swfPath: '/js/jQuery.jPlayer',
                 solution: 'flash,html',
                 supplied: 'mp3',
                 preload: 'metadata',
                 volume: 1,
                 muted: false,
                 backgroundColor: '#000000',
                 errorAlerts: false,
                 warningAlerts: false,
                 ready: function() {
                    $(this).jPlayer('setMedia', { mp3: "/streamer/index.php?action=demo&sid=fnuaask36q249tqohuip3e4tg7" });                
                 }
            });

            $(window).unload( function () { 
                $("#player_container").jPlayer("destroy");
            } );
        });
    </script>

	<div id="player_container"></div>

	<div id="wrapper" class="inner">

		<?php echo $content; ?>
		<script type="text/javascript">
		function CheckLoginSubmit(e)
		{
			if(e && e.keyCode == 13)
				$('#loginform').submit();
		}
	</script>

		<div id="login_overlay">
			<div id="form_holder">
				<div class="page-ttl">
					<strong class="sub-ttl">My Instore Radio</strong>
					<h1>Login</h1>
					<form name="loginform" id="loginform"
						action="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=user/login" method="post">
						<p>
							<label>Username<br /> <input type="text" name="LoginForm[username]"
								id="user_login" class="input" value="" size="20" tabindex="10"
								onkeydown="return CheckLoginSubmit(event);" />
							</label>
						</p>

						<p>
							<label>Password<br /> <input type="password" name="LoginForm[password]"
								id="user_pass" class="input" value="" size="20" tabindex="20"
								onkeydown="return CheckLoginSubmit(event);" />
							</label>
						</p>

						<div class="clear"></div>

						<div class="submit">
							<div id="submit" onclick="$('#loginform').submit();">Log In</div>
							<div id="cancel">Cancel</div>
							<div style="clear: both"></div>
						</div>
						<input type="submit" style="display: none" />
						<p>
							<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php?r=user/forgotpassword" >Forgot password ?</a>
						</p>
					</form>
				</div>
			</div>
			<!-- #FORM_HOLDER -->
		</div>
		<!-- #LOGIN_OVERLAY -->

		<div id="header">
			<div class="container_12">
				<div class="grid_8 alpha">
					<?php  $this->widget('zii.widgets.CMenu',array(
							'items'=>array(
									array('label'=>'Home', 'url'=>array('/site/index')),
									array('label'=>'Customers', 'url'=>array('/customers/admin')),
									array('label'=>'Songs', 'url'=>array('/songs/admin')),									
									array('label'=>'Playlist', 'url'=>array('/playlists/admin'), 'visible'=>!Yii::app()->user->isGuest),									array('label'=>'Styles', 'url'=>array('/style/admin'), 'visible'=>!Yii::app()->user->isGuest),
									array('label'=>'Jingles', 'url'=>array('/jingles/admin'), 'visible'=>!Yii::app()->user->isGuest),
								),
							'htmlOptions' => array(
									'id'=>'nav',
							),
		)); ?>

					<div class="language-select">
						<form id="frmLanguage" method="get"
							action="http://www.myinstoreradio.com/">
							<?php
								$current_url_array = explode("=",$_SERVER['REQUEST_URI']);
								if(count($current_url_array) > 1) $current_page = $current_url_array[1];
								else $current_page = '';
								//echo $current_page;
							 if($current_page == 'customers/create' || $current_page == 'customers/update&id')
							{
								?><div class="selectArea customSelect" style="width: 142px;"><div class="left"></div><div class="sel-center">English</div><a class="selectButton" href="#">&nbsp;</a><div class="disabled" style="display: none;"></div></div>
								<select name="lang" id="language1" class="customSelect outtaHere" style="width: auto" onchange="$('#frmLanguage').submit();">
								
							<?php } 
							else { ?> 
							<select name="lang" id="language1" class="customSelect"
								style="width: auto" onchange="$('#frmLanguage').submit();">
								<?php } ?>

								<option value="PT">Brazilian-Portuguese</option>

								<option value="DA">Danish</option>

								<option value="EN" selected="selected">English</option>

								<option value="AU">English (AU)</option>

								<option value="FR">French</option>

								<option value="DE">German</option>

								<option value="IT">Italian</option>

								<option value="JP">Japanese</option>

								<option value="NO">Norwegian</option>

								<option value="ES">Spanish</option>

								<option value="SV">Swedish</option>

							</select>
						</form>
					</div>
				</div>
				<div class="grid_4 omega">
					<strong class="logo"><a href="<?php echo Yii::app()->request->baseUrl; ?>">My Instore Radio</a> </strong>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div class="footer-btm">
			<div class="container_12 holder">
				<div class="grid_4 alpha">
					<a class="radio" href="contact.html">Contact</a>
				</div>
				<div class="grid_8 omega">
					<ul style="z-index: 99999999999;">
						<li><a href="mailto:support@myinstoreradio.com">Support request</a>
						</li>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div id="footer">
			<div class="container_12">
				<div class="grid_8 alpha">
					<ul>
						<li><a href="privacy.html">Privacy</a></li>
						<li><a href="signup.html">Sign up</a></li>
						<li><a href="products.html">Products/Plans</a></li>
						<li><a href="terms.html">Terms of Use</a></li>
					</ul>
				</div>

				<div class="grid_4 omega">
					<strong class="logo"><a href="#">My Instore Radio</a> </strong>
				</div>
				<div class="clear"></div>
			</div>
		</div>

</body>
</html>
