<?php	 	

/*

Template Name: Portfolio Template

*/

?>



<?php	 	 get_header();?>

        <!-- BEGIN OF PAGE TITLE -->

        <?php	 	 global $post;?>

        <?php	 	 if (have_posts()) : ?>      

        <div id="page-title">

        	<div id="page-title-inner">

                <div class="title">

                <h1>
<?php if( is_page() && !($post->post_parent==$pageID) ) { ?><div style="float:left"><?php	$parent_title = get_the_title($post->post_parent);
$parent_link = '<a href="'.$parent->guid.'">'.$parent_title.'</a>'; echo $parent_link; ?></div><div class="dot-separator-title"></div><?php } ?>
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

        	<div id="content-fullwidth">          

                <div class="maincontent">

                <?php	 	 $porto_heading = get_option('vulcan_porto_heading');?>

                <h3 class="pf-title"><?php	 	echo ($porto_heading) ? $porto_heading : "Works";?></h3>

                	<div id="pf-view"><a href="#" class="switch_thumb"><?php	 	 echo __('Switch Thumb','vulcan');?></a></div>

                	<?php	 	 

                	$porto_text  = get_option('vulcan_porto_text');

                	?>

                <p class="ie6-text"><?php	 	 echo ($porto_text) ? stripslashes($porto_text) : "";?></p>

                <?php	 	 $portfolio_2col = get_option('vulcan_portfolio_2col'); ?>

                <ul class="display <?php	 	 if ($portfolio_2col == true) echo 'thumb_view';?>">

                    <?php	 	 

                      $page = (get_query_var('paged')) ? get_query_var('paged') : 1;

                      $porto_cat = get_option('vulcan_portfolio_cid');
			

                      $porto_num = (get_option('vulcan_porto_num')) ? get_option('vulcan_porto_num') : 4;
			
                      $portfoliotext = (get_option('vulcan_portfoliotext')) ? get_option('vulcan_portfoliotext') : 40;

                      

                      if (post_type_exists('portfolio')) {

                          query_posts(array( 'post_type' => 'portfolio', 'showposts' => $porto_num, 'paged'=>$page));
				

                        } else {

                          query_posts('category_name='.$porto_cat.'&showposts='.$porto_num.'&paged='.$page);

                        }
						$port_folio_group = array();
                      while ( have_posts() ) : the_post();
						//print_r($post);
						//exit;
                      $portfolio_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
					  $project_type = get_post_custom_values('project_type');
					  if (isset($portfolio_meta['portfolio_url']) && $portfolio_meta['portfolio_url'] != '') $more_content ='<a href="'.$portfolio_meta['portfolio_url'].'">Visit Site</a>';
					  else $more_content ='<a href="'.$post->guid.'">Read more</a>';
					  $content = '<li>
                        <div class="content_block">

                            <div class="pf-box-view">
								<a href="'.$portfolio_meta['portfolio_link'].'" rel="prettyPhoto[portfolio]" title="'.$post->post_title.'">
								<img src="http://vbridge.co.uk/wp-content/themes/vulcan/timthumb.php?src='.$portfolio_meta['portfolio_thumbnail'].'&amp;h=180&amp;w=431&amp;zc=1" alt="" class="pf-img alignleft" />
								</a>
                            </div>
                            <h4><a href="'.$post->guid.'">'.$post->post_title.'</a></h4>

                            <p>'.get_the_excerpt().'</p>

                            <div class="more-button pf"> '.$more_content.'
							</div>

                        </div>
                    </li>
					  ';
					  echo $content;
					 
					  if(isset($project_type) && is_array($project_type) && !empty($project_type))
					  {
						$current_type = ucfirst($project_type[0]);
						if(array_key_exists($current_type, $port_folio_group))
						{
							$port_folio_group[$current_type][] = $content;
						}
						else{
							$port_folio_group[$current_type] = array();
							$port_folio_group[$current_type][] = $content;
						}	
					  }
					 	?>                  

                    

                    <?php	 	 endwhile;?>
					
                </ul>
				<?php 
				//echo '<pre>';
				//print_r($port_folio_group); 
				
				?>

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

                  

        </div>

        <!-- END OF CONTENT -->

        <?php	 	 wp_reset_query();?>

        <?php	 	 get_footer();?>
