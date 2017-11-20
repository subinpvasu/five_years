<?php	 	 get_header();?>
        
        <?php	 	
        $blogtext = (get_option('vulcan_blogtext')) ? get_option('vulcan_blogtext') : 80;
        $readmoretext = (get_option('vulcan_readmoretext')) ? get_option('vulcan_readmoretext') : "Read More";
        ?>        
        <!-- BEGIN OF PAGE TITLE -->      
        <div id="page-title">
        	<div id="page-title-inner">
                <div class="title">
                <h1><?php	 	 echo __('Search Results for ','vulcan');?>&quot;<?php	 	 echo $s;?>&quot;</h1>
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
        	<div id="content-left">          
                <div class="maincontent">
                      <?php	 	
                      if (have_posts()) : while ( have_posts() ) : the_post();
                    	?>                
                    <!-- begin of blog post  -->
                    <div class="left-head">
                        <div class="date"><?php	 	 the_time('d');?></div>
                        <div class="month"><?php	 	 the_time('M');?></div>
                    </div>
                    <div class="right-head">
                       <h3><a href="<?php	 	 the_permalink();?>"><?php	 	 the_title();?></a></h3>                                              
                       <div class="post-info"><?php	 	 echo __('posted by','vulcan');?>: <?php	 	 the_author_posts_link();?> &nbsp; | &nbsp; <?php	 	 echo __('category ','vulcan');?>: <?php	 	 the_category(',');?> &nbsp; | &nbsp; <?php	 	 echo __('comments ','vulcan');?>: <?php	 	 comments_popup_link(__('0 Comment','vulcan'),__('1 Comment','vulcan'),__('% Comments','vulcan'));?></div>
                    </div>
                    <div class="blog-posted">
                      <?php	 	 if (get_post_meta($post->ID,"thumbnail",true))  : ?>
                        <div class="blog-box">			
                          <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo get_post_meta($post->ID,"thumbnail",true);?>&amp;h=129&amp;w=223&amp;zc=1" alt="<?php	 	 the_title(); ?>"/>
                        </div>
                      <?php	 	 endif;?>
                    <p><?php	 	 excerpt($blogtext);?></p>
                    <div class="more-button"><a href="<?php	 	 the_permalink();?>"><?php	 	 echo $readmoretext;?></a></div>                                                
                    </div>
                    <?php	 	 endwhile;?>
                    <?php	 	 else : ?>
                    <h3><?php	 	 echo __('There\'s No Archive for ','vulcan');?>"<?php	 	 echo $s;?>"</h3><br />
                    <?php	 	 get_search_form();?>
                    <?php	 	 endif;?>                    
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
            <?php	 	 wp_reset_query();?>
          <?php	 	 get_sidebar();?>             
                  
        </div>
        <!-- END OF CONTENT -->
        <?php	 	 get_footer();?>
