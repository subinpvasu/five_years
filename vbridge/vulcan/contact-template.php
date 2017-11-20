<?php	 	

/*

Template Name: Contact Form

*/

?>





<?php	 	 get_header();?>

        <!-- BEGIN OF PAGE TITLE -->

        <?php	 	 if (have_posts()) : ?>      

        <div id="page-title">

        	<div id="page-title-inner">

                <div class="title">

                <h1><?php	 	 the_title();?></h1>

                </div>

                <div class="dot-separator-title"></div>

                <div class="description">

                <?php	 	 $data = get_post_meta($post->ID, 'vulcan_meta_options', true ); ?>

                <?php	 	 $site_slogan = get_option('vulcan_site_slogan');?>

                <p><?php	 	 if ($data['short_desc']) echo stripslashes($data['short_desc']);?></p>

                </div>

            </div>   	            

        </div>

        <!-- END OF PAGE TITLE --> 

        

        <!-- BEGIN OF CONTENT -->

        <div id="content">

        

        	<div id="contact-left">  

                <div class="maincontent">

                <?php	 	 

                while (have_posts()) : the_post();

                  the_content();

                endwhile;

                ?>

                <br />

				<!-- commenting out Map picture - Murali -->
				<!-- 
                <h4><?php	 	 bloginfo('blogname'); ?> <?php	 	 echo __('on the map','vulcan');?></h4>

                <?php	 	

                  $info_map = get_option('vulcan_info_map');

                  $gmap_source  = get_option('vulcan_gmap_source');

                ?>

                	<div class="map">

                  <a rel="prettyPhoto[iframes]"  href="<?php	 	 echo ($gmap_source) ? $gmap_source : "http://maps.google.com/?ie=UTF8&amp;ll=-6.230792,106.825991&amp;spn=0.032167,0.082397&amp;z=15&amp;output=embed";?>?iframe=true&amp;width=680&amp;height=350" class="google-map" title="<?php	 	 bloginfo('blogname');?> on the map">

                  <img src="<?php	 	 echo ($info_map) ? $info_map : bloginfo('template_directory').'/images/map.gif';?>" alt="" />

                  </a>

                  </div>
                   -->                        

                </div>

            </div>

            

            <div class="contact-separator">&nbsp;</div>

            

            <div id="contact-right">   

                  <div id="contactFormArea">

                    <?php	 	 $success_msg  = get_option('vulcan_success_msg');?>

                    <div id="emailSuccess"><?php	 	 echo ($success_msg) ? $success_msg : "Your message has been sent successfully. Thank you!";?></div>

                    <div id="maincontactform">

                      <form action="#" id="contactform"> 

                      <div>

                      <label><?php	 	 echo __('Name ','vulcan');?></label><input type="text" name="name" class="textfield" id="name" value="" /><span class="require"> *</span>

                      <label><?php	 	 echo __('Subject ','vulcan');?></label><input type="text" name="subject" class="textfield" id="subject" value="" /><span class="require"> *</span>

                      <label><?php	 	 echo __('E-mail ','vulcan');?></label><input type="text" name="email" class="textfield" id="email" value="" /><span class="require"> *</span>  

                      <label><?php	 	 echo __('Message ','vulcan');?></label><textarea name="message" id="message" class="textarea" cols="2" rows="2"></textarea><span class="require"> *</span><br />

                      <input type="submit" name="submit" class="buttoncontact" id="buttonsend" value="" />

                      <input type="hidden" name="siteurl" id="siteurl" value="<?php	 	 bloginfo('template_directory');?>" />

                      <span class="loading" style="display: none;"><?php	 	 echo __('Please wait..','vulcan');?></span>

                      </div>

                      </form>

                  </div>   

                </div>

            </div>    

          </div>

          <?php	 	 endif;?>

        </div>

        <!-- END OF CONTENT -->

        <?php	 	 get_footer();?>

