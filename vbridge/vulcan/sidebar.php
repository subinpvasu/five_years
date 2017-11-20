            <div id="content-right">
            	<!-- begin of sidebar -->
              <?php	 	
              if($post->post_parent) {
                $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&depth=1&menu_order=sort_column");
              }else{
                $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&depth=1&menu_order=sort_column");
              }  
              ?>            	
              <?php	 	 if ($children) { ?>
            	<div class="sidebar">
                    <h3><?php	 	 echo __('More ','vulcan');?><?php	 	 echo get_the_title($post->post_parent);?></h3>              
                     <ul class="sidebar-list">
                     	<?php	 	 echo $children;?>
                     </ul>             
                </div>
                <div class="sidebar-bottom"></div>
                <?php	 	 
                  }
                ?>                
                <!-- end of sidebar -->
                
                <?php	 	
                $aboutpage = get_option('vulcan_about_pid'); 
                if (is_page_template('blog-template.php') || is_category() || is_archive()) {
                  if (function_exists('dynamic_sidebar') && dynamic_sidebar('Blog Sidebar')) : else : 
                    if (function_exists('dynamic_sidebar') && dynamic_sidebar('General Sidebar'));
                  endif;
                } else if (is_page($aboutpage) || is_page_template('about-template.php')) {
                  if (function_exists('dynamic_sidebar') && dynamic_sidebar('About Page')) : else : 
                    if (function_exists('dynamic_sidebar') && dynamic_sidebar('General Sidebar'));
                  endif;
                } else if (is_single()) {
                  if (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Post')) : else : 
                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('General Sidebar')) : ?>
          	         <div class="sidebar">
                      <h3>Latest News</h3>              
                       <ul class="sidebar-list">
                       	<?php	 	 include (TEMPLATEPATH.'/placeholder/latestnews.php');?>
                       </ul>             
                      </div>
                      <div class="sidebar-bottom"></div>  
      

                      
                      <div class="sidebar-bottom"></div>            
                    <?php	 	 
                    endif;
                  endif;
                } else {
                  if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('General Sidebar')) : ?>


                       	<?php	 	  include (TEMPLATEPATH.'/placeholder/portfoliobox.php');?>

                    <div class="sidebar-bottom"></div>
        	         <div class="sidebar">
                    <h3><?php	 	 echo __('Latest News','vulcan');?></h3>              
                     <ul class="sidebar-list">
                     	<?php	 	 include (TEMPLATEPATH.'/placeholder/latestnews.php');?>
                     </ul>             
                    </div>
                      
                  <?php	 	
                  endif; 
                }                
                ?> 
            </div>   