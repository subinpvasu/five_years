<?php	 	 get_header();?>

<?php if(isset($_REQUEST['project']) && $_REQUEST['project'] != '')
			 {
			 	$posts = query_posts(array( 'post_type' => 'portfolio', 'posts_per_page' => -1));				//print_r($posts);
				if($posts)
				{
					foreach($posts as $post)
					{
						
						if(in_array($_REQUEST['project'],get_post_meta($post->ID,'project', $single)))
						{
							$portfolio_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
echo '<div id="prtfolio_show">'; ?><div style="width:100%;"><div style="background: none repeat scroll 0 0 #DF7401;color: #FFFFFF;font-weight: bold;   left: 195px;margin-top: -29px;padding: 7px;float: left;width:15%; border-top-left-radius: 6px;
    border-top-right-radius: 6px;">Featured Project</div></div>
							<div style="overflow:hidden;float:left;background: #01619D;border-bottom-left-radius: 8px;
border-bottom-right-radius: 8px;
border-top-right-radius: 8px;margin-bottom:60px">
							   <img src="<?php echo $portfolio_meta['portfolio_thumbnail'];?>" width="690px"  alt="" class="pf-img alignleft" />
							
							
							<?php
							
							echo '<div class="project"><h4>'.$post->post_title.'</h4>';
							//echo '<div class="project_close">X</div>';
							if($post->post_excerpt != '') echo '<p>'.$post->post_excerpt.'</p>';
							else echo '<p>'.wordwrap($post->post_excerpt,300).'</p>';
							?><a href="<?php	 	 the_permalink();?>"><?php	 	 echo __('Read more','vulcan');?></a><?php

							echo '</div></div></div>';
							
						}
						
	
					}
				}
			 }	 
			 ?>
        <!-- BEGIN OF FRONT-BOX -->

        <div id="mid-container">

          <?php	 	 include (TEMPLATEPATH.'/placeholder/frontbox.php');?>

        </div>

        <!-- END OF FRONT-BOX --> 

        

        <!-- BEGIN OF CONTENT -->
	

        <div id="content">

        	

            <!-- begin of content column 1 -->

            <div class="front-box-content">

            <?php	 	 

            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Column 1')) : 

              include (TEMPLATEPATH.'/placeholder/welcome.php');

            endif;            

            ?>

            </div>

            <!-- end of content column 1 -->

            

            <div class="separator-content">&nbsp;</div>

             

            <!-- begin of content column 2 -->    

            <div class="front-box-content">

            <?php	 	 

            if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Column 2')) :

              include (TEMPLATEPATH.'/placeholder/testimonial.php');

            endif;            

            ?>

            </div>

            <!-- end of content column 2 -->  

            

            <div class="separator-content">&nbsp;</div>

            

            <!-- begin of content column 3 -->                    

            <div class="front-box-content-client">

            <?php	 	 if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Homepage Column 3')) :

              include (TEMPLATEPATH.'/placeholder/clientlist.php');
			  
			  include (TEMPLATEPATH.'/placeholder/testimonials.php');

            endif;

            ?>

            </div>

            <!-- end of content column 3 -->

			 
                  
        </div>
	      
        <!-- END OF CONTENT -->

<?php	 	 get_footer();?>