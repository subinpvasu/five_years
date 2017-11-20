<div id="slideshow">
<?php	 	
  if (post_type_exists('slideshow')) { 
    $numtext = (get_option('vulcan_numtext')) ? get_option('vulcan_numtext') : 40;
    query_posts(array( 'post_type' => 'slideshow', 'showposts' => -1));
    ?>
    <ul>
      <?php	 	 
        if (have_posts()) {
        while (have_posts() ) : the_post(); 
        $data = get_post_meta($post->ID, 'vulcan_meta_options', true );
        $slideshow_url = ($data['slideshow_url']) ? $data['slideshow_url'] : get_permalink();
        $readmore = ($data['slideshow_readmore']) ? $data['slideshow_readmore'] : "Read More";
        $num_excerpt = ($data['num_excerpt']) ? $data['num_excerpt'] : "40";
      ?>
      <li>
        <?php	 	 
        if ($data['slideshow_style'] == "full image") { ?>
          <?php	 	
          if ($data['slideshow_image']) : 
          ?>
          <a href="<?php	 	 echo $slideshow_url;?>"><img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $data['slideshow_image'];?>&amp;h=280&amp;w=936&amp;zc=1" alt="<?php	 	 the_title(); ?>" /></a>
          <?php	 	 endif;?>
        <?php	 	 } else if ($data['slideshow_style'] == "with right description") { ?>
        <span class="slide-img">
        <?php	 	 if ($data['slideshow_image']) : ?>
        <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $data['slideshow_image'];?>&amp;h=280&amp;w=610&amp;zc=1" alt="<?php	 	 the_title(); ?>" />
        <?php	 	 endif;?>
        </span>
        <span class="slide-text">
            <span class="heading1-slide"><?php	 	 the_title();?></span>
	    <p>
            <?php	 	 excerpt($num_excerpt);?>
	    </p>
            <div class="clear"></div>
            <?php	 	 
              $readmore = ($data['slideshow_readmore']) ? $data['slideshow_readmore'] : __("Read More",'vulcan');
            ?>
         
        </span>   
        <?php	 	 } else if ($data['slideshow_style'] == "with left description") { ?>
        <span class="slide-text-left">
            <span class="heading1-slide"><?php	 	 the_title();?></span>
            <?php	 	 excerpt($num_excerpt);?>
            <div class="clear"></div>
         
        </span>        
        <span class="slide-img-right">
        <?php	 	 if ($data['slideshow_image']) : ?>
        <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $data['slideshow_image'];?>&amp;h=280&amp;w=610&amp;zc=1" alt="<?php	 	 the_title(); ?>" />
        <?php	 	 endif;?>
        </span>          
        <?php	 	 } else {
          if ($data['slideshow_image']) : 
          ?>
          <a href="<?php	 	 echo $slideshow_url;?>">
          <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $data['slideshow_image'];?>&amp;h=280&amp;w=936&amp;zc=1" alt="<?php	 	 the_title(); ?>" />
          <?php	 	 endif;?>
          <span class="slide-text-bottom">
            <?php	 	 excerpt($num_excerpt);?>
          </span>
          </a>
        <?php	 	 } ?>
        </li> 
      <?php	 	 endwhile; wp_reset_query();?> 
    </ul>  
    <div id="pager"></div>
  <?php	 	
    } 
  }
  ?>
</div>
