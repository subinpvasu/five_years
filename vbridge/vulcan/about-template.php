<?php	 	
/*
Template Name: About Template
*/
?>

<?php	 	 get_header();?>
        <!-- BEGIN OF PAGE TITLE -->
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
                <?php	 	 while (have_posts()) : the_post();?>
                <?php	 	 the_content();?>
                <?php	 	 endwhile;?>
                <?php	 	 
                $enable_team = get_option('vulcan_enable_team');
                if ($enable_team == true) {?>
                <?php	 	
                    $counter = 0;
          					$team_catid = get_option('vulcan_team_cid');
                    $team = new WP_Query('category_name='.$team_catid.'&showposts=-1');
                    while ($team->have_posts()) : $team->the_post();
                    $staff_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
          					$counter++;
                  ?>
                	<!-- begin of team -->
                	   <div class="about-item">
                      <div class="about-team">
                        <?php	 	 if ($staff_meta['thumb_image']) {?>
                        <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $staff_meta['thumb_image'];?>&amp;h=60&amp;w=60&amp;zc=1" alt="" class="imgleft border" />
                        <?php	 	 } else { ?>
                          <img src="<?php	 	 bloginfo('template_directory');?>/images/team1.jpg" alt="" class="imgleft border" />
                        <?php	 	 } ?>
                      </div>
                      <strong><a href="<?php	 	 the_permalink();?>"><?php	 	 the_title();?></a></strong><p><?php	 	 excerpt(30);?></p>
                    </div>
                    <?php	 	 if ($counter ==1 || $counter ==3 || $counter == 5 || $counter == 7) {;?>	
                      <div class="spacer">&nbsp;</div>
                    <?php	 	 } ?>                    
                  <!-- end of team -->
                  <?php	 	 endwhile;?>
                  <?php	 	 } ?>
                </div>
            </div>
            <?php	 	 wp_reset_query();?>
          <?php	 	 get_sidebar();?>             
                  
        </div>
        <!-- END OF CONTENT -->
        <?php	 	 get_footer();?>
