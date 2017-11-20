<?php	 	 get_header();?>
        <!-- BEGIN OF PAGE TITLE -->
        <?php	 	 if (have_posts()) : ?>      
        <div id="page-title">
        	<div id="page-title-inner">
                <div class="title">
                <h1>
<?php if( is_page() && !($post->post_parent==$pageID) ) { ?><div style="float:left"><?php	$parent_title = get_the_title($post->post_parent);
$parent_link = '<a href="'.get_page_link($post->post_parent).'">'.$parent_title.'</a>'; echo $parent_link; ?></div><div class="dot-separator-title"></div><?php } ?>
                <div style="float:left"><?php	 the_title();?></div></h1>
                </div>
                
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
                </div>
            </div>
            <?php	 	 endif;?>
          <?php	 	 get_sidebar();?>             
                  
        </div>
        <!-- END OF CONTENT -->
        <?php	 	 get_footer();?>