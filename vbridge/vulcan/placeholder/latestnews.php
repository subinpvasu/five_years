                <!-- begin of company-news -->

                 
				  
				  <?php	 	 

                    $blog_cats_include = get_option('vulcan_blog_cats_include');

                    if(is_array($blog_cats_include)) {

                      $blog_include = implode(",",$blog_cats_include);

                    }

                    $listblog = new WP_Query("cat=$blog_include&showposts=4");

          					while ($listblog->have_posts()) : $listblog->the_post();

                  ?>                               

                    <li><a href="<?php	 	 the_permalink();?>"><?php	 	 the_title();?> - <strong><?php	 	 the_time('d F Y');?></strong></a></li>

                  <?php	 	 endwhile;wp_reset_query();?>

  

                <!-- end of company-news -->