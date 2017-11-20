<?php	 	
/*
Template Name: Blog Template
*/
?>
<?php	 	 get_header();?>
        <?php	 	 global $post;?>
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
        	<div id="content-left">          
                <div class="maincontent">
                      <?php	 	
                      
                      $blog_cats_include = get_option('vulcan_blog_cats_include');
                      if(is_array($blog_cats_include)) {
                        $blog_include = implode(",",$blog_cats_include);
                      } 
                      
                      $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                      $blog_num = (get_option('vulcan_blog_num')) ? get_option('vulcan_blog_num') : 4; 
                      $blogtext = (get_option('vulcan_blogtext')) ? get_option('vulcan_blogtext') : 80;
                      $readmoretext = (get_option('vulcan_readmoretext')) ? get_option('vulcan_readmoretext') : "Read More";
                      query_posts("cat=$blog_include&showposts=$blog_num&paged=$page");
                      while ( have_posts() ) : the_post();
                      $blog_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
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
                      <?php	 	 if ($blog_meta['thumb_image'])  : ?>
                        <div class="blog-box">
                          <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $blog_meta['thumb_image'];?>&amp;h=129&amp;w=223&amp;zc=1" alt="<?php	 	 the_title(); ?>"/>
                        </div>
                      <?php	 	 endif;?>
                    <p><?php	 	 excerpt($blogtext);?></p>
                    <div class="more-button"><a href="<?php	 	 the_permalink();?>"><?php	 	 echo $readmoretext;?></a></div>                                        
                    </div>
                    <?php	 	 endwhile;?>
                    
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