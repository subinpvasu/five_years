                <ul class="client-list">
                  <?php	 	 
                    $counter= 0;
                    $client_catid = get_option('vulcan_client_cid');
                    $client = new WP_Query('category_name='.$client_catid.'&showposts=8');
          					while ($client->have_posts()) : $client->the_post();
          					$client_meta = get_post_meta($post->ID, 'vulcan_meta_options', true );
          					$counter++;
                  ?>                
                    <li <?php	 	 if ($counter == 4 || $counter == 8) echo 'class="client-last"';?>>
                    <a href="<?php	 	 the_permalink();?>">
                    <?php	 	 if ($client_meta['thumb_image']) { ?>
                    <img src="<?php	 	 bloginfo('template_directory');?>/timthumb.php?src=<?php	 	 echo $client_meta['thumb_image'];?>&amp;h=64&amp;w=64&amp;zc=1" alt="<?php	 	 the_title(); ?>" />
                    <?php	 	 } else { ?>
                    <img src="<?php	 	 bloginfo('template_directory');?>/images/client-logo.gif" alt="" />
                    <?php	 	 } ?>
                    </a>
                    </li>
                    <?php	 	 endwhile;?>
                    <?php	 	 wp_reset_query();?>
                </ul>