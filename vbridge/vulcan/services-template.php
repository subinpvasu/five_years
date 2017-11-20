<?php	 	
/*
Template Name: Services Template
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
          <div id="content-fullwidth">
               
                <div class="maincontent">
                <?php	 	 
                  if (have_posts()) : while (have_posts()) : the_post();
                    the_content();
                  endwhile; endif;
                  
                  global $post;
                  $counter = 0;
                  $$services_page = get_option('vulcan_services_pid');
                  $servicespid = get_page_by_title($services_page);
                  $spid = ($post->ID) ? ($post->ID)  : $servicespid->id; 
                  query_posts('post_type=page&post_parent='.$spid.'&showposts=-1');                  
                  while ( have_posts() ) : the_post();
                  $services_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
                  $counter++;
                 	?>
                	<div class="services-column">
                    <?php	 	 if ($services_meta['page_thumbnail_image'])  {?>		
                      <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $services_meta['page_thumbnail_image'];?>&amp;h=87&amp;w=107&amp;zc=1" alt="<?php	 	 the_title(); ?>" class="imgleft"/>
                    <?php	 	 } else { ?>                	
                    <img src="<?php	 	 bloginfo('template_directory');?>/images/services1.jpg" alt="" class="imgleft" />
                    <?php	 	 }?>
                    <h4><a href="<?php	 	 the_permalink();?>"><?php	 	 the_title();?></a></h4>
                    <p><?php	 	 excerpt(40);?></p>
                    	<div class="more-button"><a href="<?php	 	 the_permalink();?>"><?php	 	 echo __('Learn More','vulcan');?></a></div>
                    </div>
                    <?php	 	 if ($counter ==1 || $counter ==3 || $counter == 5 || $counter == 7 || $counter == 9 || $counter == 11) {;?>
                      <div class="services-spacer">&nbsp;</div>
                    <?php	 	 }?>
        					<?php	 	 endwhile;?>                
                </div>
            <?php	 	 endif;?>
          </div>
        </div>
        <!-- END OF CONTENT -->
        <?php	 	 get_footer();?>
