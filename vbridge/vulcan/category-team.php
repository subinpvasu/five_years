<?php	 	 get_header();?>
        
        <?php	 	
        $blogtext = (get_option('vulcan_blogtext')) ? get_option('vulcan_blogtext') : 80;
        $readmoretext = (get_option('vulcan_readmoretext')) ? get_option('vulcan_readmoretext') : "Read More";
        ?>        
        <?php	 	 if (have_posts()) : ?>
        <!-- BEGIN OF PAGE TITLE -->      
        <div id="page-title">
        	<div id="page-title-inner">
                <div class="title">
            		<h1><?php	 	 single_cat_title(); ?></h1>
                </div>                
            </div>   	            
        </div>
        <!-- END OF PAGE TITLE --> 
        
        <!-- BEGIN OF CONTENT -->
        <div id="content">
        	<div id="content-left">          
                <div class="maincontent">
                      <?php	 	
                      while ( have_posts() ) : the_post();
                      $meta_data = get_post_meta($post->ID, 'vulcan_meta_options', true );
                    	?>                
                    <!-- begin of blog post  -->
                    <div class="blog-posted">
                      <?php	 	 if ($meta_data['thumb_image'])  : ?>
                        <?php	 	 if ($meta_data['thumb_image']) {?>
                        <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $meta_data['thumb_image'];?>&amp;h=60&amp;w=60&amp;zc=1" alt="" class="imgleft border" />
                        <?php	 	 } else { ?>
                          <img src="<?php	 	 bloginfo('template_directory');?>/images/team1.jpg" alt="" class="imgleft border" />
                        <?php	 	 } ?>      
                      <?php	 	 endif;?>
                    <h4><a href="<?php	 	 the_permalink();?>"><?php	 	 the_title();?></a></h4>
                    <?php	 	 excerpt(40);?>  
                    </div>
                    <div class="clr"></div>
                    <div class="line-divider"></div>
                    <?php	 	 endwhile;?>
                    <!-- end of blog post -->
                    <div class="clr"></div>
                    <div class="blog-pagination"><!-- page pagination -->                                       	     			
                    <?php	 	 
            				if (function_exists('wp_pagenavi')) :
            				    wp_pagenavi();
            				  else : 
            				?>
                  		<div class="page-navigation">
                  			<div class="alignleft"><?php	 	 next_posts_link(__('&laquo; Previous Entries','vulcan')) ?></div>
                  			<div class="alignright"><?php	 	 previous_posts_link(__('Next Entries &raquo;','vulcan')) ?></div>
                  			<div class="clr"></div>
                  		</div>
                    <?php	 	 endif;?>       
                  </div>                          
                </div>
            </div>
            <?php	 	 endif;?>
            <?php	 	 wp_reset_query();?>
          <?php	 	 get_sidebar();?>             
                  
        </div>
        <!-- END OF CONTENT -->
        <?php	 	 get_footer();?>
