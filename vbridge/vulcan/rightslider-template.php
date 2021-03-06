<?php	 	

/*

Template Name: RightSlider Template

*/

?>

<?php	 	 get_header();



$current_pag_id = get_the_ID();
			$page = (get_query_var('paged')) ? get_query_var('paged') : 1;

                      $porto_cat = get_option('vulcan_portfolio_cid');
			

                      $porto_num = (get_option('vulcan_porto_num')) ? get_option('vulcan_porto_num') : 4;
			
                      $portfoliotext = (get_option('vulcan_portfoliotext')) ? get_option('vulcan_portfoliotext') : 40;

                      

                      if (post_type_exists('portfolio')) {

                         $all_portfolios = get_posts(array( 'posts_per_page'   => -1,'post_type' => 'portfolio'));
				

                        } 
						$port_folio_group = array();
						
                     foreach($all_portfolios as $selected_portfolio)
					{
                      $portfolio_meta = get_post_meta($selected_portfolio->ID, 'vulcan_meta_options', true );
					  $project_type = get_post_meta($selected_portfolio->ID, 'project_type', true );
					  if (isset($portfolio_meta['portfolio_url']) && $portfolio_meta['portfolio_url'] != '') $more_content ='<a href="'.$portfolio_meta['portfolio_url'].'">Visit Site</a>';
					  else $more_content ='<a href="'.$selected_portfolio->guid.'">Read more</a>';
					  $content_array = array();
					  $content_array['titlte'] = $selected_portfolio->post_title;
					  $content_array['post_link'] = $selected_portfolio->guid;
					  $content_array['image'] = $portfolio_meta['portfolio_thumbnail'];
					  if(isset($project_type))
					  {
						$current_type = ucfirst($project_type);
						if(array_key_exists($current_type, $port_folio_group))
						{
							$port_folio_group[$current_type][] = $content_array;
						}
						else{
							$port_folio_group[$current_type] = array();
							$port_folio_group[$current_type][] = $content_array;
						}	
					  }
				?>
                <?php	}
				
				
				?>
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
		<!-- BEGIN OF SLIDER -->
			
			
				<!-- End of collecting data -->
            	<!-- begin of slider -->
				<div id="main_div" style="width: 640px; background-color: #000; opacity: 0.6; height: 340px; padding-top: 20px;  border-radius: 10px; margin-bottom:10px">
						<!-- #region Jssor Slider Begin -->

						<!-- Generated by Jssor Slider Maker. -->
						<!-- This demo works without jquery library. -->

						<script type="text/javascript" src="<?php bloginfo('template_directory');?>/js/jssor.slider.min.js"></script>
						<!-- use jssor.slider.debug.js instead for debug -->
						<script>
							jssor_1_slider_init = function() {
								
								var jssor_1_SlideshowTransitions = [
								  {$Duration:1200,x:-0.3,$During:{$Left:[0.3,0.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
								  {$Duration:1200,x:0.3,$SlideOut:true,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2}
								];
								
								var jssor_1_options = {
								  $AutoPlay: true,
								  $SlideshowOptions: {
									$Class: $JssorSlideshowRunner$,
									$Transitions: jssor_1_SlideshowTransitions,
									$TransitionsOrder: 1
								  },
								  $ArrowNavigatorOptions: {
									$Class: $JssorArrowNavigator$
								  },
								  $BulletNavigatorOptions: {
									$Class: $JssorBulletNavigator$
								  },
								  $ThumbnailNavigatorOptions: {
									$Class: $JssorThumbnailNavigator$,
									$Cols: 1,
									$Align: 0,
									$NoDrag: true
								  }
								};
								
								var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
								
								//responsive code begin
								//you can remove responsive code if you don't want the slider scales while window resizing
								function ScaleSlider() {
									var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
									if (refSize) {
										refSize = Math.min(refSize, 600);
										jssor_1_slider.$ScaleWidth(refSize);
									}
									else {
										window.setTimeout(ScaleSlider, 30);
									}
								}
								ScaleSlider();
								$Jssor$.$AddEvent(window, "load", ScaleSlider);
								$Jssor$.$AddEvent(window, "resize", ScaleSlider);
								$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
								//responsive code end
							};
						</script>

						<style>
							
							/* jssor slider bullet navigator skin 01 css */
							/*
							.jssorb01 div           (normal)
							.jssorb01 div:hover     (normal mouseover)
							.jssorb01 .av           (active)
							.jssorb01 .av:hover     (active mouseover)
							.jssorb01 .dn           (mousedown)
							*/
							.jssorb01 {
								position: absolute;
							}
							.jssorb01 div, .jssorb01 div:hover, .jssorb01 .av {
								position: absolute;
								/* size of bullet elment */
								width: 12px;
								height: 12px;
								filter: alpha(opacity=70);
								opacity: .7;
								overflow: hidden;
								cursor: pointer;
								border: #000 1px solid;
							}
							.jssorb01 div { background-color: gray; }
							.jssorb01 div:hover, .jssorb01 .av:hover { background-color: #d3d3d3; }
							.jssorb01 .av { background-color: #fff; }
							.jssorb01 .dn, .jssorb01 .dn:hover { background-color: #555555; }

							/* jssor slider arrow navigator skin 05 css */
							/*
							.jssora05l                  (normal)
							.jssora05r                  (normal)
							.jssora05l:hover            (normal mouseover)
							.jssora05r:hover            (normal mouseover)
							.jssora05l.jssora05ldn      (mousedown)
							.jssora05r.jssora05rdn      (mousedown)
							*/
							.jssora05l, .jssora05r {
								display: block;
								position: absolute;
								/* size of arrow element */
								width: 40px;
								height: 40px;
								cursor: pointer;
								background: url('img/a17.png') no-repeat;
								overflow: hidden;
							}
							.jssora05l { background-position: -10px -40px; }
							.jssora05r { background-position: -70px -40px; }
							.jssora05l:hover { background-position: -130px -40px; }
							.jssora05r:hover { background-position: -190px -40px; }
							.jssora05l.jssora05ldn { background-position: -250px -40px; }
							.jssora05r.jssora05rdn { background-position: -310px -40px; }

							/* jssor slider thumbnail navigator skin 09 css */
							
							.jssort09-600-45 .p {
								position: absolute;
								top: 0;
								left: 0;
								width: 600px;
								height: 45px;
							}
							
							.jssort09-600-45 .t {
								font-family: verdana;
								font-weight: normal;
								position: absolute;
								width: 100%;
								height: 100%;
								top: 0;
								left: 0;
								color:#fff;
								line-height: 45px;
								font-size: 20px;
								padding-left: 10px;
							}
							#jssor_1 a:visited {
								color: #fff;
								text-decoration: none;
							}
							
						</style>
						<?php
						$slider_array = array();
						//$current_pag_id == 1799;
						
						if(isset($port_folio_group['Web']) && $current_pag_id == '1799')
						{
							$slider_array = $port_folio_group['Web'];
						}
						if(isset($port_folio_group['Mobile']) && $current_pag_id == '1806')
						{
							$slider_array = $port_folio_group['Mobile'];
						}
						if(isset($port_folio_group['Database']) && $current_pag_id == '1808')
						{
							$slider_array = $port_folio_group['Database'];
						}
						
						
						?>

						<div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 600px; height: 300px; overflow: hidden; visibility: hidden;">
							<!-- Loading Screen -->
							<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
								<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
								<div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
							</div>
							<div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 600px; height: 300px; overflow: hidden;">
								<?php if(isset($slider_array) && !empty($slider_array))
								{ 
									foreach($slider_array as $selected_slider_array)
									{
									?>
									<div data-p="112.50" style="display: none;">
										<img data-u="image" src="<?=$selected_slider_array['image']?>" />
										<div data-u="thumb"><a href="<?=$selected_slider_array['post_link']?>" style="color:#fff"><?=$selected_slider_array['titlte']?></a></div>
									</div>
									<?php  }
								} ?>
							
							</div>
							<!-- Thumbnail Navigator -->
							<div data-u="thumbnavigator" class="jssort09-600-45" style="position:absolute;bottom:0px;left:0px;width:600px;height:45px;">
								<div style="position: absolute; top: 0; left: 0; width: 100%; height:100%; background-color: #000; filter:alpha(opacity=40.0); opacity:0.4;"></div>
								<!-- Thumbnail Item Skin Begin -->
								<div data-u="slides" style="cursor: default;">
									<div data-u="prototype" class="p">
										<div data-u="thumbnailtemplate" class="t"></div>
									</div>
								</div>
								<!-- Thumbnail Item Skin End -->
							</div>
							<!-- Bullet Navigator -->
							<div data-u="navigator" class="jssorb01" style="bottom:16px;right:16px;">
								<div data-u="prototype" style="width:12px;height:12px;"></div>
							</div>
							<!-- Arrow Navigator -->
							<span data-u="arrowleft" class="jssora05l" style="top:0px;left:8px;width:40px;height:40px;" data-autocenter="2"></span>
							<span data-u="arrowright" class="jssora05r" style="top:0px;right:8px;width:40px;height:40px;" data-autocenter="2"></span>
						</div>
					</div>
					<script>
						jssor_1_slider_init();
					</script>
				<!-- End of slider -->
		<!-- END OF SLIDER -->
        
        
                <?php	 	 while (have_posts()) : the_post();?>
                <?php	 	 the_content();?>
                <?php	 	 endwhile;?>     
                </div>
            </div>
            <?php	 	 endif;?>
          <?php	 	// get_sidebar('slider-bar');
		  get_sidebar();
		  ?>             
                  
        </div>
        <!-- END OF CONTENT -->
        <?php	 	 get_footer();?>