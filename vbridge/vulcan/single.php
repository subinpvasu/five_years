<?php	 	 get_header();?>
        <!-- BEGIN OF PAGE TITLE -->
<?php	 	
  $blog_cats_include = get_option('vulcan_blog_cats_include');
  $team_cat = get_option('vulcan_team_cid');
  $client_cat = get_option('vulcan_client_cid');
?>        
        <?php	 	 if (have_posts()) : ?>      
        <div id="page-title">
        	<div id="page-title-inner">
                <div class="title">
                <h1>
                  <?php	 	
                    if(is_array($blog_cats_include)) {
                      $blog_include = implode(",",$blog_cats_include);
                    } 
                    $porto_cat = get_option('vulcan_portfolio_cid');
                    if (in_category($blog_include)) { 
                      echo __('Blog','vulcan'); 
                    } else if (get_post_type($post->ID) == "portfolio" ) {
                      echo __('Portfolio','vulcan');
                    } else if (in_category($team_cat)) { 
                      echo __('Our Team','vulcan'); 
                    } else if (in_category($client_cat)) { 
                      echo __('Our Client','vulcan');
                    }
                  ?>                
                </h1>
                </div>                
            </div>   	            
        </div>
        <!-- END OF PAGE TITLE --> 
        
        <!-- BEGIN OF CONTENT -->
        <div id="content">
        	<div id="content-left">          
                <div class="maincontent">
                <?php	 	 
                  while (have_posts()) : the_post();
                  $data = get_post_meta($post->ID, 'vulcan_meta_options', true );
                ?>
                    <!-- begin of blog post  -->
                    <?php	 	 if (in_category($blog_include)) : ?>
                    <div class="left-head">
                        <div class="date"><?php	 	 the_time('d');?></div>
                        <div class="month"><?php	 	 the_time('M');?></div>
                    </div>
                    <?php	 	 endif;?>
                    <div class="right-head">
                       <h3><?php	 	 the_title();?></h3>       
                       <?php	 	 if (in_category($blog_include)) : ?>                                       
                       <div class="post-info"><?php	 	 echo __('posted by ','vulcan');?>: <?php	 	 the_author_posts_link();?> &nbsp; | &nbsp; category : <?php	 	 the_category(',');?> &nbsp; | &nbsp; <?php	 	 echo __('comments ','vulcan');?>: <?php	 	 comments_popup_link(__('0 Comment','vulcan'),__('1 Comment','vulcan'),__('% Comments','vulcan'));?></div>
                       <?php	 	 endif; ?>
                    </div>
                    <div class="blog-posted">
                      <?php	 	 if (get_post_type($post->ID) == "portfolio") {
                        if ($data['portfolio_link']) {
                          if (is_youtube($data['portfolio_link'])) { ?>
                            <div class="movie_container"><a href="<?php	 	 echo $data['portfolio_link'];?>"  rel="youtube"></a></div>
                          <?php	 	
                          } else if (is_vimeo($data['portfolio_link'])) { ?>
                            <div class="movie_container"><a href="<?php	 	 echo $data['portfolio_link'];?>"  rel="vimeo"></a></div>    
                          <?php	 	  
                          } else if (is_quicktime($data['portfolio_link'])) { 
                            ?>
                            <div class="movie_container"><a href="<?php	 	 echo $data['portfolio_link'];?>"  rel="quicktime"></a></div>
                            <?php	 	
                          } else if (is_flash($data['portfolio_link'])) { ?>
                            <div class="movie_container"><a href="<?php	 	 echo $data['portfolio_link'];?>"  rel="flash"></a></div>
                            <?php	 	
                          } else { ?>
                            <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $data['portfolio_link'];?>&amp;h=287&amp;w=620&amp;zc=1" alt="<?php	 	 the_title(); ?>" class="imgbox alignleft" />
                            <?php	 	
                          }
                        } 
                      } else if (in_category($blog_include)) { 
                        if ($data['video_image_link']) {
                          if (is_youtube($data['video_image_link'])) { ?>
                            <div class="movie_container"><a href="<?php	 	 echo $data['video_image_link'];?>"  rel="youtube"></a></div>
                          <?php	 	
                          } else if (is_vimeo($data['video_image_link'])) { ?>
                            <div class="movie_container"><a href="<?php	 	 echo $data['video_image_link'];?>"  rel="vimeo"></a></div>    
                          <?php	 	  
                          } else if (is_quicktime($data['video_image_link'])) { 
                            ?>
                            <div class="movie_container"><a href="<?php	 	 echo $data['video_image_link'];?>"  rel="quicktime"></a></div>
                            <?php	 	
                          } else if (is_flash($data['video_image_link'])) { ?>
                            <div class="movie_container"><a href="<?php	 	 echo $data['video_image_link'];?>"  rel="flash"></a></div>
                            <?php	 	
                          }
                        }  else { if($blog_meta['thumb_image']) {?>

                          <div class="blog-box">
                            <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $data['thumb_image'];?>&amp;h=129&amp;w=223&amp;zc=1" alt="<?php	 	 the_title(); ?>"/>
                            </div>
                            <?php }	 	
                          }
                        } else if (in_category($team_cat)) {
                            if ($data['thumb_image']) : ?>
                              <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $data['thumb_image'];?>&amp;h=60&amp;w=60&amp;zc=1" alt="" class="imgleft border" />
                          <?php	 	 endif;
                        } else if (in_category($client_cat)) {
                            if ($data['thumb_image']) : ?>
                              <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $data['thumb_image'];?>&amp;h=60&amp;w=60&amp;zc=1" alt="" class="imgleft border" />
                          <?php	 	 endif;
                        }
                        ?>
                      <?php	 	 the_content();?>
                      <div class="clr"></div>
                      <?php	 	 
                      $disable_authorbox = get_option('vulcan_disable_authorbox');
                      if ($disable_authorbox == false) : 
                      ?>                                          
                        <div class="author">
                        <?php	 	 if (function_exists('get_avatar')) { 
                          echo get_avatar(get_the_author_meta('user_email'), '70'); 
                        } else {?>
                        <img src="<?php	 	 bloginfo('template_directory');?>/images/author.jpg" alt="" class="imgleft authorpic" />
                        <?php	 	 } ?>
                        <h5>About <?php	 	 the_author();?></h5>
                        <?php	 	 the_author_meta('description'); ?>
                        </div>
                      <?php	 	 endif; ?>
                      <div class="clr"></div><br />
                      <?php	 if(!in_category('Testimonials',$post->ID))	 comments_template('', true); ?>                                         
                    </div>                
                <?php	 	 endwhile;?>                     
                </div>
            </div>
            <?php	 	 endif;?>
          <?php	 	 get_sidebar();?>             
                  
        </div>
        <!-- END OF CONTENT -->
        <?php	 	 get_footer();?>