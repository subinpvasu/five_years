<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="<?php	 	 bloginfo('html_type'); ?>; charset=<?php	 	 bloginfo('charset'); ?>"  />

<title><?php	 	 if (is_home () ) { bloginfo('name'); echo " - "; bloginfo('description'); 

} elseif (is_category() ) {single_cat_title(); echo " - "; bloginfo('name');

} elseif (is_single() || is_page() ) {single_post_title(); echo " - "; bloginfo('name');

} elseif (is_search() ) {bloginfo('name'); echo " search results: "; echo wp_specialchars($s);

} else { wp_title('',true); }?></title>

<meta name="generator" content="WordPress <?php	 	 bloginfo('version'); ?>" />

<meta name="robots" content="follow, all" />

<meta name="description" content="vBridge Ltd is a Software Services firm based in UK, USA and India with clients across the globe. Specialists in java, php and open source packages, vBridge excels in Quality Assurance, minimal but productive and useful processes and stresses on high standards of communication to ensure customer satisfaction.">

<meta name="keywords" content="PHP Web Development, MYSQL PHP development, Google adwords software development, Adwords product, OCR development, Microsoft Adcenter Product, Bing Adcenter Product, Adcenter product">


<link rel="stylesheet" href="<?php	 	 bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />


<link rel="shortcut icon" href="<?php	 	 bloginfo('template_directory'); ?>/favicon.ico" />

<link rel="alternate" type="application/rss+xml" title="<?php	 	 bloginfo('name'); ?> RSS Feed" href="<?php	 	 bloginfo('rss2_url'); ?>" />

<link rel="pingback" href="<?php	 	 bloginfo('pingback_url'); ?>" />
 
<?php	 	 wp_head(); ?>

<!--[if IE 6]>    

	<link href="<?php	 	 bloginfo('template_directory');?>/css/ie6.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="<?php	 	 bloginfo('template_directory');?>/js/DD_belatedPNG.js"></script>

	<script type="text/javascript"> 

	   DD_belatedPNG.fix('img'); 

       DD_belatedPNG.fix('#pager a, ul.list-bottom li');

       DD_belatedPNG.fix('#footer-content, .dot-separator');

       DD_belatedPNG.fix('blockquote');   

	</script>    

<![endif]-->

<!--[if IE 7]>    

	<style type="text/css">

    #pager{top:260px;}

    #slideshow ul, #slideshow li{margin:12px 0px 0px 6px;}

    #content .front-box-content{padding-bottom:45px;}

    </style>

<![endif]-->

<!--[if IE 8]>    

	<style type="text/css">

    #pager{top:260px;}

    </style>

<![endif]-->



<!-- ////////////////////////////////// -->

<!-- //      Javascript Files        // -->

<!-- ////////////////////////////////// -->

<?php	 	 if (is_home()) : ?>

<script type="text/javascript">

  jQuery(document).ready(function($) {
     	setTimeout('document.getElementById("usoverlay").style.display="none"',8000);
	setTimeout('document.getElementById("usoverlay").style.display="block"',2000);
	$('#usamessage').delay(2000).show().animate({"right": "+=500px"},1200).delay(5000).animate({"right": "-=500px"},1200);

    <?php	 	 $slideshowspeed = (get_option('vulcan_slideshowspeed')) ? get_option('vulcan_slideshowspeed') : 5000; ?>

     $('#slideshow ul').cycle({

        timeout: <?php	 	 echo $slideshowspeed;?>,  // milliseconds between slide transitions (0 to disable auto advance)

        fx:      'fade', // choose your transition type, ex: fade, scrollUp, shuffle, etc...            

        pager:   '#pager',  // selector for element to use as pager container

        pause:   0,	  // true to enable "pause on hover"

        pauseOnPagerHover: 0 // true to pause when hovering over pager link

    });

  });

</script>

<?php	 	 endif; ?>
<script type="text/javascript">

  jQuery(document).ready(function($) {
     //added by arif
	
	 var elements = Array ('.long_h2');
        $(elements.join(',')).each(function() {//alert($(this).text());
	   
            $(this).append(
                '<div class="long-left" style="width:' +
                $(this).position().left +
                'px;height:' +
                ($(this).height() + 22) +
                'px;">&nbsp;</div>');
           $(this).after('<br />');
        });
        $(window).resize(function() {
            $('.long-left').each(function() {
                var parent = $(this).parent();
                $(this).width(parent.position().left);
                $(this).height(parent.height() + 22);
            });
        }); 
     });
</script>

<?php	 	 /*?><script type="text/javascript" src="<?php	 	 bloginfo('template_directory');?>/js/cufon-yui.js"></script>

<?php	 	 $cufon_fonts = get_option('vulcan_cufon_fonts'); if ($cufon_fonts == "") $cufon_fonts = "Vegur_300.font.js";?>

<script type="text/javascript" src="<?php	 	 bloginfo('template_directory');?>/js/fonts/<?php	 	 echo $cufon_fonts;?>"></script>



<script type="text/javascript">

    Cufon.replace('h1') ('h2') ('h3') ('h4') ('h5') ('h6') ('.navigation ul',{hover:true})('.slide-more') ('.heading1-slide') ('.heading2-slide') ('ul.navigation',{hover:true})('.more-button') ('.page-navigation',{hover:true}) ('.date') ('.month') ('.wp-pagenavi') ;

    Cufon.set('fontWeight', 'Normal');

</script>  <?php	 	 */?>

</head>

<body>

<? include("usmessage.php");?>
	<div id="container">
	
    	<!-- BEGIN OF HEADER -->

    	<div <?php	 	 if (is_home()) echo 'id="top-container"'; else echo 'id="top-container-inner"';?>>

        

        	<!-- begin of logo and mainmenu -->

        	<div id="header">

            	<div id="logo">

              <?php	 	 $logo_url  = get_option('vulcan_logo');?>

								<a href="<?php	 	 bloginfo('url');?>"><img src="<?php	 	 if ($logo_url != "") {echo $logo_url;} else { echo bloginfo('template_directory').'/images/logo.gif';}?>" alt="<?php	 	 bloginfo('blogname');?>" /></a>

              

              </div>
               
<div id="mainmenus" style="display: none; width: auto; float: left;">
               <nav class="navbar">
  <div class="container-fluid">
    <div class="navbar-header">
      <button  type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="float: none">
        <b>MENU</b>
      </button>
      
     </div>
    <div class="collapse navbar-collapse" id="myNavbar">
     <?php	 	 

                if (function_exists('wp_nav_menu')) { 
                wp_nav_menu( array( 'menu_class' => 'nav navbar-nav', 'theme_location' => 'topnav', 'fallback_cb'=>'vulcan_topmenu_pages','depth' =>4 ) );
              

                } else {  

                  vulcan_topmenu_pages();

                } ?>
                    </div>
  </div>
</nav>
    
               </div>    
              <div id="mainmenu">
 
                <?php	 	 

                if (function_exists('wp_nav_menu')) { 
                wp_nav_menu( array( 'menu_class' => 'navigation', 'theme_location' => 'topnav', 'fallback_cb'=>'vulcan_topmenu_pages','depth' =>4 ) );
              

                } else {  

                  vulcan_topmenu_pages();

                } ?>

              </div>    
              
              
                

            </div>

            <!-- end of logo and mainmenu -->

            

            <?php	 	 if (is_home()) include (TEMPLATEPATH.'/slideshow.php'); ?>

            

            <!-- begin of welcome-slogan -->

            <?php	 	 if (is_home()) : ?>

            <div id="slogan">

            <?php	 //	 $site_slogan = get_option('vulcan_site_slogan');?>

            <!--<h1>--><?php	 	// if ($site_slogan) echo stripslashes($site_slogan); else echo "PHP | Java | .Net | Web | Search Engine Marketing | Data Entry";?><!--</h1>-->

            </div>
			<!-- commenting Get in Tough Button - Murali -->
            <!-- div class="dot-separator"></div>

            <div id="get-in-touch">

            <?php	 	 

            $contact_page = get_option('vulcan_contact_pid');

            $contact_pid = get_page_by_title($contact_page);

            $getintouch_btn = get_option('vulcan_getintouch_btn');

            ?>
            <a href="<?php	 	 echo ($getintouch_btn) ? $getintouch_btn : get_permalink($contact_pid);?>"><img src="<?php	 	 bloginfo('template_directory');?>/images/get-in-touch.gif" alt="" /></a>

            </div-->           

            <?php	 	 endif; ?>

            <!-- end of welcome-slogan -->

                    

        </div>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script>
$(document).ready(function(){
	$("#menu-item-422>a").attr("data-toggle", "dropdown");
	$("#menu-item-429>a").attr("data-toggle", "dropdown");
});
  </script>
        <!-- END OF HEADER -->