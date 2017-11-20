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
             	  <?php	 	 $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
             	  <?php	 	 /* If this is a category archive */ if (is_category()) { ?>
            		<h1><?php	 	 single_cat_title(); ?></h1>
             	  <?php	 	 /* If this is a tag archive */ } elseif( is_tag() ) { ?>
            		<h1>Posts Tagged &#8216;<?php	 	 single_tag_title(); ?>&#8217;</h1>
             	  <?php	 	 /* If this is a daily archive */ } elseif (is_day()) { ?>
            		<h1>Archive for <?php	 	 the_time('F jS, Y'); ?></h1>
             	  <?php	 	 /* If this is a monthly archive */ } elseif (is_month()) { ?>
            		<h1>Archive for <?php	 	 the_time('F, Y'); ?></h1>
             	  <?php	 	 /* If this is a yearly archive */ } elseif (is_year()) { ?>
            		<h1>Archive for <?php	 	 the_time('Y'); ?></h1>
            	  <?php	 	 /* If this is an author archive */ } elseif (is_author()) { ?>
            		<h1>Author Archive</h1>
             	  <?php	 	 /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
            		<h1>Blog Archives</h1>
             	  <?php	 	 } ?>
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
                    <div class="left-head">
                        <div class="date"><?php	 	 the_time('d');?></div>
                        <div class="month"><?php	 	 the_time('M');?></div>
                    </div>
                    <div class="right-head">
                       <h3><a href="<?php	 	 the_permalink();?>"><?php	 	 the_title();?></a></h3>                                              
                       <div class="post-info"><?php	 	 echo __('posted by','vulcan');?>: <?php	 	 the_author_posts_link();?> &nbsp; | &nbsp; <?php	 	 echo __('category ','vulcan');?>: <?php	 	 the_category(',');?> &nbsp; | &nbsp; <?php	 	 echo __('comments ','vulcan');?>: <?php	 	 comments_popup_link(__('0 Comment','vulcan'),__('1 Comment','vulcan'),__('% Comments','vulcan'));?></div>
                    </div>
                    <div class="blog-posted">
                      <?php	 	 if ($meta_data['thumb_image'])  : ?>
                        <div class="blog-box">			
                          <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $meta_data['thumb_image'];?>&amp;h=129&amp;w=223&amp;zc=1" alt="<?php	 	 the_title(); ?>"/>
                        </div>
                      <?php	 	 endif;?>
                    <p><?php	 	 excerpt($blogtext);?></p>
                    <div class="more-button"><a href="<?php	 	 the_permalink();?>"><?php	 	 echo $readmoretext;?></a></div>                                                
                    </div>
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
