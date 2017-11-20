        <!-- BEGIN OF FOOTER -->

        <div id="bottom-container">

        	<div id="footer-content">

            

            	<!-- begin of footer-address --> 

            	<div id="footer-address">

                <?php	 	 

                $info_address = get_option('vulcan_info_address');

                $info_phone = get_option('vulcan_info_phone');

                $info_fax = get_option('vulcan_info_fax');

                $info_email = get_option('vulcan_info_email');

                

                ?>

          <?php	 	 /*?>      <img src="<?php	 	 $footer_logo = get_option('vulcan_footer_logo'); if ($footer_logo) : echo $footer_logo;?> <?php	 	 else : ?> <?php	 	 bloginfo('template_directory');?>/images/footer_vbridge_logo.png<?php	 	 endif;?>"  alt="<?php	 	 bloginfo('blogname');?>" /><?php	 	 */?>
				<p>vBridge</p>
                <p><?php	 	 echo ($info_address) ? $info_address : "5 Halter Close, Borehamwood,";?></p>
                <p><?php	 	 echo ($info_address) ? $info_address : "Greater London,  WD6 2SN, United Kingdom";?></p>

                <p><?php	 	 echo __('Phone','vulcan');?> : <?php	 	 echo ($info_phone) ? $info_phone : "+44 208 207 2254, +44 7722197496";?><br/><?php	 	 echo __('Email ','vulcan');?>: <?php	 	 echo ($info_email) ? $info_email : "info@vbridge.co.uk";?></p>

                </div>

                <!-- end of footer-address -->

                

                <div id="footer-news">

                <?php	 	 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom')) : ?>

                <h3><?php	 	 echo __('Company News','vulcan');?></h3>

                    <ul class="list-bottom">

                    <?php	 	 include (TEMPLATEPATH.'/placeholder/latestnews.php');?>

                  </ul>

                <?php	 	 endif;?>

                </div>                

                <!-- begin of footer-menu and copyright -->

                <div id="footer-last">

                	<div id="footer-menu">

                  <?php	 	 

                    if (function_exists('wp_nav_menu')) { 

                      wp_nav_menu( array( 'menu_class' => 'navigation-footer', 'theme_location' => 'footernav','fallback_cb'=> 'vulcan_footermenu_pages','sort_column' => 'menu_order', ) );

                    } else {  

                      vulcan_footermenu_pages();

                    } ?>

                    </div>

                    <div id="footer-copyright">

                    <?php	 	 $footer_text  = get_option('vulcan_footer_text');?>

                    <?php	 	 echo ($footer_text) ? stripslashes($footer_text) : "Copyright &copy; 2010 Vulcan Company.  All rights reserved";?>

                    </div>

                </div>

                <!-- end of footer-menu and copyright -->

                            

            </div>

        </div>

        <!-- END OF FOOTER -->

    	

    </div>

    <?php	 	 

      $ga_code = get_option('vulcan_ga_code');

      if ($ga_code) echo stripslashes($ga_code);

    ?>

    <?php	 	 wp_footer();?>


    </body>

</html>