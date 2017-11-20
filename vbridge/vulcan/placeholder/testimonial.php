            <h3>Client Testimonials</h3>
			<a href="/category/testimonials">
            <?php	 	 

    	    $testi_catid = get_option('vulcan_testimonial_cid');

            $testimonial = new WP_Query("category_name=$testi_catid&showposts=1");

            while ($testimonial->have_posts()) : $testimonial->the_post(); 

            ?>

            <blockquote>
           
            <p><?php	 	 excerpt(25);?></p>

            </blockquote>

            <p><strong><?php	 	 the_title();?></strong></p>
            
            </a>

            <?php	 	 endwhile;?>

