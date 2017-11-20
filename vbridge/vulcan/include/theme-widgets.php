<?php	 	

/* Widgetable Functions  */

if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'ID' => 'sidebar',
    'name'=>'General Sidebar',
    'before_widget' => '<div class="sidebar">',
    'after_widget' => '</div><div class="sidebar-bottom"></div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  register_sidebar(array(
    'ID' => 'sidebar_blog',
    'name'=>'Blog Sidebar',
    'before_widget' => '<div class="sidebar">',
    'after_widget' => '</div><div class="sidebar-bottom"></div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));
  register_sidebar(array(
    'ID' => 'sidebar_single',
    'name'=>'Single Post',
    'before_widget' => '<div class="sidebar">',
    'after_widget' => '</div><div class="sidebar-bottom"></div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));  
  register_sidebar(array(
    'ID' => 'about_page',
    'name'=>'About Page',
    'before_widget' => '<div class="sidebar">',
    'after_widget' => '</div><div class="sidebar-bottom"></div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  )); 
  register_sidebar(array(
    'ID' => 'homepage',
    'name'=>'Homepage Column 1',
    'before_widget' => '<div class="widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));   
  register_sidebar(array(
    'ID' => 'homepage',
    'name'=>'Homepage Column 2',
    'before_widget' => '<div class="widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));   
  register_sidebar(array(
    'ID' => 'homepage',
    'name'=>'Homepage Column 3',
    'before_widget' => '<div class="widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));       
  register_sidebar(array(
    'ID' => 'bottom',
    'name'=>'bottom',
    'before_widget' => '<div class="footer-widget">',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>'
  ));             
/* More About Us Widget */

class PageBox_Widget extends WP_Widget {
  function PageBox_Widget() {
    $widgets_opt = array('description'=>'Display pages as small box in sidebar');
    parent::WP_Widget(false,$name= "Vulcan - Page to Box",$widgets_opt);
  }
  
  
  function form($instance) {
    global $post;
    
    $pageid = esc_attr($instance['pageid']);
    $pagetitle = esc_attr($instance['pagetitle']);
    $opt_childpage = esc_attr($instance['opt_childpage']);
    $pageexcerpt = (esc_attr($instance['pageexcerpt'])) ? esc_attr($instance['pageexcerpt']) : 20;
    
		$pages = get_pages();
		$listpages = array();
		foreach ($pages as $pagelist ) {
		   $listpages[$pagelist->ID] = $pagelist->post_title;
		}
  ?>
    <p><label for="abouttitle">Title:
  		<input id="<?php	 	 echo $this->get_field_id('pagetitle'); ?>" name="<?php	 	 echo $this->get_field_name('pagetitle'); ?>" type="text" class="widefat" value="<?php	 	 echo $pagetitle;?>" /></label></p>  
	 <p><small>Please select the page.</small></p>
		<select  name="<?php	 	 echo $this->get_field_name('pageid'); ?>">  id="<?php	 	 echo $this->get_field_id('pageid'); ?>" >
			<?php	 	 foreach ($listpages as $opt => $val) { ?>
		<option value="<?php	 	 echo $opt ;?>" <?php	 	 if ( $pageid  == $opt) { echo ' selected="selected" '; }?>><?php	 	 echo $val; ?></option>
		<?php	 	 } ?>
		</select>
		</label></p>
  <p>
		<input class="checkbox" type="checkbox" <?php	 	 if ($opt_childpage == "on") echo "checked";?> id="<?php	 	 echo $this->get_field_id('opt_childpage'); ?>" name="<?php	 	 echo $this->get_field_name('opt_childpage'); ?>" />
		<label for="<?php	 	 echo $this->get_field_id('opt_childpage'); ?>"><small>Incude sub pages?</small></label><br />
    </p>
    <p><label for="pageexcerpt">Number of words for excerpt :
  		<input id="<?php	 	 echo $this->get_field_id('pageexcerpt'); ?>" name="<?php	 	 echo $this->get_field_name('pageexcerpt'); ?>" type="text" class="widefat" value="<?php	 	 echo $pageexcerpt;?>" /></label></p>  
    <?php	 	    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $pageid = apply_filters('pageid',$instance['pageid']);
    $abouttitle = apply_filters('pagetitle',$instance['pagetitle']);
    $opt_childpage = apply_filters('opt_childpage',$instance['opt_childpage']);
    $pageexcerpt = apply_filters('pageexcerpt',$instance['pageexcerpt']);
    $pagetitle = ($abouttitle) ? $abouttitle : get_the_title($pageid); 
    echo $before_widget;
    echo $before_title.$pagetitle.$after_title;
    
    if ($opt_childpage == "on") {

      $aboutpage = new WP_Query('post_type=page&page_id='.$pageid);
      while ($aboutpage->have_posts()) : $aboutpage->the_post(); ?>       
        <p><?php	 	 excerpt($pageexcerpt);?></p>
      <?php	 	
      endwhile;
      
      $aboutpagelist = new WP_Query('post_type=page&post_parent='.$pageid);
    	while ($aboutpagelist->have_posts()) : $aboutpagelist->the_post();      
      $page_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );  
      ?>
        <p>
        <?php	 	 if ($page_meta['page_thumbnail_image']) { ?>
        <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $page_meta['page_thumbnail_image'];?>&amp;h=34&amp;w=34&amp;zc=1" alt="<?php	 	 the_title(); ?>" class="imgleft" />
        <?php	 	 } ?>
          <strong><?php	 	 the_title();?></strong><br />
					 <?php	 	 excerpt(13);?></p> 
      <?php	 	
      endwhile;
    } else {      
    $aboutpage = new WP_Query('post_type=page&page_id='.$pageid);
    while ($aboutpage->have_posts()) : $aboutpage->the_post(); ?>       
      <p><?php	 	 excerpt($pageexcerpt);?></p>
    <?php	 	
    endwhile;
    }
    
    echo $after_widget;
    wp_reset_query();
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("PageBox_Widget");'));

/* Latest News Widget */

class LatestNews_Widget extends WP_Widget {
  
  function LatestNews_Widget() {
    $widgets_opt = array('description'=>'Vulcan Latest News Theme Widget');
    parent::WP_Widget(false,$name= "Vulcan -  Latest News",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $catid = esc_attr($instance['catid']);
    $newstitle = esc_attr($instance['newstitle']);
    $numnews = esc_attr($instance['numnews']);
    
    $categories_list = get_categories('hide_empty=0');
    
    $categories = array();
    foreach ($categories_list as $catlist) {
    	$categories[$catlist->cat_ID] = $catlist->cat_name;
    }

  ?>
    <p><label for="newstitle">Title:
  		<input id="<?php	 	 echo $this->get_field_id('newstitle'); ?>" name="<?php	 	 echo $this->get_field_name('newstitle'); ?>" type="text" class="widefat" value="<?php	 	 echo $newstitle;?>" /></label></p>  
	 <p><small>Please select category for <b>News</b>.</small></p>
		<select  name="<?php	 	 echo $this->get_field_name('catid'); ?>">  id="<?php	 	 echo $this->get_field_id('catid'); ?>" >
			<?php	 	 foreach ($categories as $opt => $val) { ?>
		<option value="<?php	 	 echo $opt ;?>" <?php	 	 if ( $catid  == $opt) { echo ' selected="selected" '; }?>><?php	 	 echo $val; ?></option>
		<?php	 	 } ?>
		</select>
		</label></p>	
    <p><label for="numnews">Number to display:
  		<input id="<?php	 	 echo $this->get_field_id('numnews'); ?>" name="<?php	 	 echo $this->get_field_name('numnews'); ?>" type="text" class="widefat" value="<?php	 	 echo $numnews;?>" /></label></p>
    <?php	 	    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $catid = apply_filters('catid',$instance['catid']);
    $newstitle = apply_filters('newstitle',$instance['newstitle']);
    $numnews = apply_filters('numnews',$instance['numnews']);    
    
    if ($newstitle =="") $newstitle = "Latest News";
    if ($numnews == "") $numnews = 3;
    
    echo $before_widget;
    echo $before_title.$newstitle.$after_title;
    $latestnews = new WP_Query('cat='.$catid.'&showposts='.$numnews);
    ?>
    <ul class="itemlist">
    <?php	 	
    while ( $latestnews->have_posts() ) : $latestnews->the_post();    
    ?>
    <li><a href="<?php	 	 the_permalink();?>"><?php	 	 the_title();?> <strong><?php	 	 the_date('d F Y');?></strong></a></li>
   <?php	 	
   endwhile;
   ?>
   </ul>
   <?php	 	
   wp_reset_query();    
   echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("LatestNews_Widget");'));

/* Testimonial Widget */

class Testimonial_Widget extends WP_Widget {
  function Testimonial_Widget() {
    $widgets_opt = array('description'=>'Vulcan Testimonial Theme Widget');
    parent::WP_Widget(false,$name= "Vulcan - Testimonial",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $catid = esc_attr($instance['catid']);
    $testititle = esc_attr($instance['testititle']);
    $numtesti = esc_attr($instance['numtesti']);
    
    $categories_list = get_categories('hide_empty=0');
    
    $categories = array();
    foreach ($categories_list as $catlist) {
    	$categories[$catlist->cat_ID] = $catlist->cat_name;
    }

  ?>
    <p><label for="testititle">Title:
  		<input id="<?php	 	 echo $this->get_field_id('testititle'); ?>" name="<?php	 	 echo $this->get_field_name('testititle'); ?>" type="text" class="widefat" value="<?php	 	 echo $testititle;?>" /></label></p>  
	 <p><small>Please select category for <b>Testimonial</b>.</small></p>
		<select  name="<?php	 	 echo $this->get_field_name('catid'); ?>"  id="<?php	 	 echo $this->get_field_id('catid'); ?>" >
			<?php	 	 foreach ($categories as $opt => $val) { ?>
		<option value="<?php	 	 echo $opt ;?>" <?php	 	 if ( $catid  == $opt) { echo ' selected="selected" '; }?>><?php	 	 echo $val; ?></option>
		<?php	 	 } ?>
		</select>
		</label></p>	
    <p><label for="numtesti">Number to display:
  		<input id="<?php	 	 echo $this->get_field_id('numtesti'); ?>" name="<?php	 	 echo $this->get_field_name('numtesti'); ?>" type="text" class="widefat" value="<?php	 	 echo $numtesti;?>" /></label></p>
    <?php	 	    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $catid = apply_filters('catid',$instance['catid']);
    $testititle = apply_filters('testititle',$instance['testititle']);
    $numtesti = apply_filters('numtesti',$instance['numtesti']);    
    
    if ($numtesti == "") $numtesti = 1;
    if ($testititle == "") $testititle = "Testimonials";
    echo $before_widget;
    echo $before_title.$testititle.$after_title;
    $testis = new WP_Query('cat='.$catid.'&showposts='.$numtesti);
 
    while ( $testis->have_posts() ) : $testis->the_post();
    $testiposts = strip_tags(get_the_content());    
    ?>
    <blockquote><p><?php	 	 excerpt(25);?></p></blockquote>
  	<strong><?php	 	 the_title();?></strong><div class="clr"></div><br />
   <?php	 	
   endwhile;
   wp_reset_query();    
   echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("Testimonial_Widget");'));

/* Team Widget */

class Team_Widget extends WP_Widget {
  function Team_Widget() {
    $widgets_opt = array('description'=>'Vulcan theme widget for displaying Team/Staff of your company ');
    parent::WP_Widget(false,$name= "Vulcan - Team",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $catid = esc_attr($instance['catid']);
    $teamititle = esc_attr($instance['teamtitle']);
    
    $categories_list = get_categories('hide_empty=0');
    
    $categories = array();
    foreach ($categories_list as $catlist) {
    	$categories[$catlist->cat_ID] = $catlist->cat_name;
    }

  ?>
    <p><label for="teamtitle">Title:
  		<input id="<?php	 	 echo $this->get_field_id('teamtitle'); ?>" name="<?php	 	 echo $this->get_field_name('teamtitle'); ?>" type="text" class="widefat" value="<?php	 	 echo $teamtitle;?>" /></label></p>  
	 <p><small>Please select category for <b>Team</b>.</small></p>
		<select  name="<?php	 	 echo $this->get_field_name('catid'); ?>" id="<?php	 	 echo $this->get_field_id('catid'); ?>" >
			<?php	 	 foreach ($categories as $opt => $val) { ?>
		<option value="<?php	 	 echo $opt ;?>" <?php	 	 if ( $catid  == $opt) { echo ' selected="selected" '; }?>><?php	 	 echo $val; ?></option>
		<?php	 	 } ?>
		</select>
		</label></p>	
    <?php	 	    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $catid = apply_filters('catid',$instance['catid']);
    $teamtitle = apply_filters('teamtitle',$instance['teamtitle']);
    if ($teamtitle =="") $teamtitle = "Our Team";
    echo $before_widget;
    ?>
    <?php	 	
    echo $before_title.$teamtitle.$after_title;
    $teams = new WP_Query('cat='.$catid.'&showposts=-1');
 
    while ( $teams->have_posts() ) : $teams->the_post();    
    $staff_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
    ?>
      <p>
      <?php	 	 if ($staff_meta['thumb_image']) {?>
      <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $staff_meta['thumb_image'];?>&amp;h=60&amp;w=60&amp;zc=1" alt="" class="imgleft border" />
      <?php	 	 } else { ?>
        <img src="<?php	 	 bloginfo('template_directory');?>/images/team1.jpg" alt="" class="imgleft border" />
      <?php	 	 } ?>
      <p><strong><a href="<?php	 	 the_permalink();?>"><?php	 	 the_title();?></a></strong><br /><?php	 	 excerpt(12);?></p>    
   <?php	 	
   endwhile;
   ?>
   <?php	 	
   wp_reset_query();    
   echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("Team_Widget");'));

/* Post to Homepage Box or Sidebar Box Widget */

class PostBox_Widget extends WP_Widget {
  function PostBox_Widget() {
    $widgets_opt = array('description'=>'Display Posts as small box in sidebar');
    parent::WP_Widget(false,$name= "Vulcan - Post to Box",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $postid = esc_attr($instance['postid']);
    $opt_thumbnail = esc_attr($instance['opt_thumbnail']);
    $postexcerpt = esc_attr($instance['postexcerpt']);
    
		$centitaposts = get_posts('numberposts=-1')
		?>  
	<p><label>Please select post display
			<select  name="<?php	 	 echo $this->get_field_name('postid'); ?>">  id="<?php	 	 echo $this->get_field_id('postid'); ?>" >
				<?php	 	 foreach ($centitaposts as $post) { ?>
			<option value="<?php	 	 echo $post->ID;?>" <?php	 	 if ( $postid  ==  $post->ID) { echo ' selected="selected" '; }?>><?php	 	 echo  the_title(); ?></option>
			<?php	 	 } ?>
			</select>
	</label></p>
  <p>
		<input class="checkbox" type="checkbox" <?php	 	 if ($opt_thumbnail == "on") echo "checked";?> id="<?php	 	 echo $this->get_field_id('opt_thumbnail'); ?>" name="<?php	 	 echo $this->get_field_name('opt_thumbnail'); ?>" />
		<label for="<?php	 	 echo $this->get_field_id('opt_thumbnail'); ?>"><small>display thumbnail?</small></label><br />
    </p>
    <p><label for="postexcerpt">Number of words for excerpt :
  		<input id="<?php	 	 echo $this->get_field_id('postexcerpt'); ?>" name="<?php	 	 echo $this->get_field_name('postexcerpt'); ?>" type="text" class="widefat" value="<?php	 	 echo $postexcerpt;?>" /></label></p>  
    <?php	 	    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $postid = apply_filters('postid',$instance['postid']);
    $opt_thumbnail = apply_filters('opt_thumbnail',$instance['opt_thumbnail']);
    $postexcerpt = apply_filters('postexcerpt',$instance['postexcerpt']);
    if ($postexcerpt =="") $postexcerpt = 20;
    
    echo $before_widget;
    $postlist = new WP_Query('p='.$postid);
    
    while ($postlist->have_posts()) : $postlist->the_post();
    $post_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
    ?>
      <h3><?php	 	 the_title();?></h3>
      <p><?php	 	 excerpt($postexcerpt);?><a href="<?php	 	 the_permalink();?>" class="readmore">Read more</a></p>
      <?php	 	 if ($opt_thumbnail == "on") { ?>
        <?php	 	 if ($post_meta['thumb_image']) { ?>
        <div class="blog-box">
        <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $post_meta['thumb_image'];?>&amp;h=100&amp;w=260&amp;zc=1" alt="<?php	 	 the_title(); ?>"/>
        </div>
        <?php	 	 } 
        } ?>      
    <?php	 	      
    endwhile;
    echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("PostBox_Widget");'));

/* Client Widget */
class Client_Widget extends WP_Widget {
  function Client_Widget() {
    $widgets_opt = array('description'=>'Vulcan Client List Widget');
    parent::WP_Widget(false,$name= "Vulcan - Client List ",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $catid = esc_attr($instance['catid']);
    $clienttitle = esc_attr($instance['clienttitle']);
    $numclient = esc_attr($instance['numclient']);
    
    $categories_list = get_categories('hide_empty=0');
    
    $categories = array();
    foreach ($categories_list as $catlist) {
    	$categories[$catlist->cat_ID] = $catlist->cat_name;
    }

  ?>
    <p><label for="portotitle">Title:
  		<input id="<?php	 	 echo $this->get_field_id('clenttitle'); ?>" name="<?php	 	 echo $this->get_field_name('clenttitle'); ?>" type="text" class="widefat" value="<?php	 	 echo $portotitle;?>" /></label></p>    
	 <p><small>Please select category for <b>Client</b>.</small></p>
		<select  name="<?php	 	 echo $this->get_field_name('catid'); ?>">  id="<?php	 	 echo $this->get_field_id('catid'); ?>" />
			<?php	 	 foreach ($categories as $opt => $val) { ?>
		<option value="<?php	 	 echo $opt ;?>" <?php	 	 if ( $catid  == $opt) { echo ' selected="selected" '; }?>><?php	 	 echo $val; ?></option>
		<?php	 	 } ?>
		</select>
		</label></p>	
    <p><label for="numclient">Number to display:
  		<input id="<?php	 	 echo $this->get_field_id('numclient'); ?>" name="<?php	 	 echo $this->get_field_name('numclient'); ?>" type="text" class="widefat" value="<?php	 	 echo $numclient;?>" /></label></p>
    <?php	 	    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $catid = apply_filters('catid',$instance['catid']);
    $clenttitle = apply_filters('clenttitle',$instance['clenttitle']);
    $numclient = apply_filters('numclient',$instance['numclient']);    
    
    if ($numclient == "") $numclient = 4;    
     
    echo $before_widget;
    echo $before_title.$clenttitle.$after_title;    
    $counter= 0;
    $client = new WP_Query('cat='.$catid.'&showposts='.$numclient);  
    $counter++;  
    ?>
    <ul class="client-list">
			<?php	 	 
			$counter = 0;
      while ( $client->have_posts() ) : $client->the_post();
      $counter++; 
			$client_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
			?>
      <li <?php	 	 if ($ID == "homepage") if ($counter == 4 || $counter == 8) echo 'class="client-last"';?>>
      <?php	 	 if ($client_meta['thumb_image']) : ?>
      <a  href="<?php	 	 the_permalink();?>" ><img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $client_meta['thumb_image'];?>&amp;h=64&amp;w=64&amp;zc=1" alt="<?php	 	 the_title(); ?>" /></a>
      <?php	 	 endif;?>
      </li>
    	<?php	 	 endwhile;?>
		</ul>
   <?php	 	
   echo $after_widget;
   wp_reset_query();    
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("Client_Widget");'));

/* Client Widget */
class Portfolio_Widget extends WP_Widget {
  function Portfolio_Widget() {
    $widgets_opt = array('description'=>'Vulcan Portfolio List Widget');
    parent::WP_Widget(false,$name= "Vulcan - Portfolio Widget",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $portfoliotitle = esc_attr($instance['portfoliotitle']);
    $numportfolio = esc_attr($instance['numportfolio']);
    
  ?>
    <p><label for="portfoliotitle">Title:
  		<input id="<?php	 	 echo $this->get_field_id('portfoliotitle'); ?>" name="<?php	 	 echo $this->get_field_name('portfoliotitle'); ?>" type="text" class="widefat" value="<?php	 	 echo $portfoliotitle;?>" /></label></p>    
    <p><label for="numportfolio">Number to display:
  		<input id="<?php	 	 echo $this->get_field_id('numportfolio'); ?>" name="<?php	 	 echo $this->get_field_name('numportfolio'); ?>" type="text" class="widefat" value="<?php	 	 echo $numportfolio;?>" /></label></p>
    <?php	 	    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $portfoliotitle = apply_filters('portfoliotitle',$instance['portfoliotitle']);
    $numportfolio = apply_filters('numportfolio',$instance['numportfolio']);    
    
    if ($numportfolio == "") $numportfolio = 4;
    if ($portfoliotitle == "") $portfoliotitle = "Latest Portfolio";
     
    echo $before_widget;
    echo $before_title.$portfoliotitle.$after_title;
    $portfolio = new WP_Query(array( 'post_type' => 'portfolio', 'showposts' => $numportfolio));
    ?>
    <ul class="client-list">
			<?php	 	 
			$counter = 0;
      while ( $portfolio->have_posts() ) : $portfolio->the_post();
      $counter++; 
      $portfolio_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
			?>
      <li <?php	 	 if ($ID == "homepage") if ($counter == 4 || $counter == 8) echo 'class="client-last"';?>>
      <?php	 	 if ($portfolio_meta['portfolio_thumbnail']) : ?>
      <a  href="<?php	 	 the_permalink();?>" ><img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $portfolio_meta['portfolio_thumbnail'];?>&amp;h=64&amp;w=64&amp;zc=1" alt="<?php	 	 the_title(); ?>" /></a>
      <?php	 	 endif;?>
      </li>
    	<?php	 	 endwhile;?>
		</ul>
   <?php	 	
   echo $after_widget;
   wp_reset_query();    
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("Portfolio_Widget");'));

/* Banner Advertisement Widget */
class AdsBanner_Widget extends WP_Widget {
  function AdsBanner_Widget () {
    $widgets_opt = array('description'=>'260x120 pixel Banner Advertisement Widget');
    parent::WP_Widget(false,$name= "Vulcan - Banner Advertisement",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $bannertitle = esc_attr($instance['bannertitle']);
    $banner_image1 = esc_attr($instance['banner_image1']);
    $banner_url1 = esc_attr($instance['banner_url1']);
    $banner_image2 = esc_attr($instance['banner_image2']);
    $banner_url2 = esc_attr($instance['banner_url2']);
    $banner_image3 = esc_attr($instance['banner_image3']);
    $banner_url3 = esc_attr($instance['banner_url3']);
    $banner_image4 = esc_attr($instance['banner_image4']);
    $banner_url4 = esc_attr($instance['banner_url4']);            
  ?>
    <p><label for="bannertitle">Title:
  		<input id="<?php	 	 echo $this->get_field_id('bannertitle'); ?>" name="<?php	 	 echo $this->get_field_name('bannertitle'); ?>" type="text" class="widefat" value="<?php	 	 echo $bannertitle;?>" /></label></p>    
    <p><label for="banner_image1">Banner Image #1  Source:
  		<input id="<?php	 	 echo $this->get_field_id('banner_image1'); ?>" name="<?php	 	 echo $this->get_field_name('banner_image1'); ?>" type="text" class="widefat" value="<?php	 	 echo $banner_image1;?>" /></label></p>
    <p><label for="banner_url1">Banner Url #1  Source:
  		<input id="<?php	 	 echo $this->get_field_id('banner_url1'); ?>" name="<?php	 	 echo $this->get_field_name('banner_url1'); ?>" type="text" class="widefat" value="<?php	 	 echo $banner_url1;?>" /></label></p>
    <p><label for="banner_image2">Banner Image #2  Source:
  		<input id="<?php	 	 echo $this->get_field_id('banner_image2'); ?>" name="<?php	 	 echo $this->get_field_name('banner_image2'); ?>" type="text" class="widefat" value="<?php	 	 echo $banner_image2;?>" /></label></p>
    <p><label for="banner_url2">Banner Url #2  Source:
  		<input id="<?php	 	 echo $this->get_field_id('banner_url2'); ?>" name="<?php	 	 echo $this->get_field_name('banner_url2'); ?>" type="text" class="widefat" value="<?php	 	 echo $banner_url2;?>" /></label></p>
    <p><label for="banner_image3">Banner Image #3  Source:
  		<input id="<?php	 	 echo $this->get_field_id('banner_image3'); ?>" name="<?php	 	 echo $this->get_field_name('banner_image3'); ?>" type="text" class="widefat" value="<?php	 	 echo $banner_image3;?>" /></label></p>
    <p><label for="banner_url3">Banner Url #3  Source:
  		<input id="<?php	 	 echo $this->get_field_id('banner_url3'); ?>" name="<?php	 	 echo $this->get_field_name('banner_url3'); ?>" type="text" class="widefat" value="<?php	 	 echo $banner_url3;?>" /></label></p>    
    <p><label for="banner_image4">Banner Image #4  Source:
  		<input id="<?php	 	 echo $this->get_field_id('banner_image4'); ?>" name="<?php	 	 echo $this->get_field_name('banner_image4'); ?>" type="text" class="widefat" value="<?php	 	 echo $banner_image4;?>" /></label></p>
    <p><label for="banner_url3">Banner Url #4  Source:
  		<input id="<?php	 	 echo $this->get_field_id('banner_url4'); ?>" name="<?php	 	 echo $this->get_field_name('banner_url4'); ?>" type="text" class="widefat" value="<?php	 	 echo $banner_url4;?>" /></label></p>            		
    <?php	 	    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $clenttitle = apply_filters('clenttitle',$instance['clenttitle']);
    
    $bannertitle = apply_filters('bannertitle',$instance['bannertitle']);
    $banner_image1 = apply_filters('banner_image1',$instance['banner_image1']);
    $banner_url1 = apply_filters('banner_url1',$instance['banner_url1']);
    $banner_image2 = apply_filters('banner_image2',$instance['banner_image2']);
    $banner_url2 = apply_filters('banner_url2',$instance['banner_url2']);
    $banner_image3 = apply_filters('banner_image3',$instance['banner_image3']);
    $banner_url3 = apply_filters('banner_url3',$instance['banner_url3']);
    $banner_image4 = apply_filters('banner_image4',$instance['banner_image4']);
    $banner_url4 = apply_filters('banner_url4',$instance['banner_url4']);  
    
    if ($bannertitle == "") $bannertitle = "Sponsor";
     
    echo $before_widget;
    echo $before_title.$bannertitle.$after_title;  
    ?>
    <ul class="ads-list">
      <li><a href="<?php	 	 echo $banner_url1;?>"><img src="<?php	 	 echo $banner_image1;?>" alt="" /></a></li>
      <li><a href="<?php	 	 echo $banner_url2;?>"><img src="<?php	 	 echo $banner_image2;?>" alt="" /></a></li>                    
      <li><a href="<?php	 	 echo $banner_url3;?>"><img src="<?php	 	 echo $banner_image3;?>" alt="" /></a></li>                                
      <li><a href="<?php	 	 echo $banner_url4;?>"><img src="<?php	 	 echo $banner_image4;?>" alt="" /></a></li>    
		</ul>
		<div class="clr"></div>
   <?php	 	
   echo $after_widget;
   wp_reset_query();    
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("AdsBanner_Widget");'));
?>