<?php	 	
/* Custom Write Panel */

$key = "vulcan_meta_options";

/* Add Meta Box for Page */
function vulcan_page_meta_boxes() {
  $meta_boxes = array(
    "short_desc" => array(
      "name" => "short_desc",
      "title" => "Short Description",
      "description" => "Add short description to your pages.",
      "type" => "textarea"
    ),
    "page_thumbnail_image" => array(
      "name" => "page_thumbnail_image",
      "title" => "Thumbnail Image",
      "description" => "Add thumbnail image url, will be use for your page thumbnail, for example in Services child pages list.",
      "type" => "text"
    )
  );
  
  return $meta_boxes;
}

function  page_meta_boxes() {
  global $post, $key;
  $meta_boxes = vulcan_page_meta_boxes();
  ?>

  <table class="form-table">
  <?php	 	
  wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );
  
  foreach($meta_boxes as $meta_box) {
  $data = get_post_meta($post->ID, $key, true);
  
		if ( $meta_box['type'] == 'text' )
			get_meta_text_input( $meta_box, $data[$meta_box['name']] );
		elseif ( $meta_box['type'] == 'textarea' )
			get_meta_textarea( $meta_box, $data[$meta_box['name']] );
    }
   ?>
  </table>
  <?php	 	
}

/* Add Meta Box for Portfolio */
function vulcan_portfolio_meta_boxes() {
  $meta_boxes = array(
    "portfolio_thumbnail" => array(
      "name" => "portfolio_thumbnail",
      "title" => "Image thumbnail",
      "description" => "Add thumbnail image url for your portfolio item thumbnail.",
      "type" => "text"
    ),
    "portfolio_link" => array(
      "name" => "portfolio_link",
      "title" => "portfolio link",
      "description" => "please enter image or video url if you want to create video post.<br/>Images : <br />http://localhost/ovum/wp-content/uploads/2010/07/image.jpg<br/> Video : <br />
      http://www.youtube.com/watch?v=tESK9RcyexU<br />
      http://vimeo.com/12816548<br />
      http://localhost/vulcan/wp-content/uploads/2010/07/sample.3gp<br />
      http://localhost/vulcan/wp-content/uploads/2010/07/sample.mp4<br />
      http://localhost/vulcan/wp-content/uploads/2010/07/sample.mov<br />
      http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf?width=680&height=405<br />
      Note : for swf movie, you need to specify the width and height for movie, as above example",
      "type" => "text"
    ),
    "portfolio_url" => array(
      "name" => "portfolio_url",
      "title" => "Custom URL",
      "description" => "Add link / custom URL for your portfolio items, eg. link to external url.",
      "type" => "text"
    ),          
  );
  
  return $meta_boxes;
}

function  portfolio_meta_boxes() {
  global $post, $key;
  $meta_boxes = vulcan_portfolio_meta_boxes();
  ?>

  <table class="form-table">
  <?php	 	
  wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );
  
  foreach($meta_boxes as $meta_box) {
  $data = get_post_meta($post->ID, $key, true);
  
		if ( $meta_box['type'] == 'text' )
			get_meta_text_input( $meta_box, $data[$meta_box['name']] );
		elseif ( $meta_box['type'] == 'textarea' )
			get_meta_textarea( $meta_box, $data[$meta_box['name']] );
    }
   ?>
  </table>
  <?php	 	
}

/* Add Meta Box for Slideshow Custom Post Type */
function vulcan_slideshow_meta_boxes() {
  $meta_boxes = array(
    "slideshow_image" => array(
      "name" => "slideshow_image",
      "title" => "Slideshow Image",
      "description" => "Add image url for your slideshow.",
      "type" => "text"
    ),
    "slideshow_url" => array(
      "name" => "slideshow_url",
      "title" => "Slideshow Url",
      "description" => "Link url for slideshow.",
      "type" => "text"
    ),
    "slideshow_readmore" => array(
      "name" => "slideshow_readmore",
      "title" => "Slideshow Read More Text",
      "description" => "Please enter the read more text for slideshow, eg : Continue Reading, Read More.",
      "type" => "text"
    ),
    "slideshow_style" => array(
      "name" => "slideshow_style",
      "title" => "Slideshow Stage Style",
      "description" => "Please one style of them for each image slideshow.",
      "type" => "select",
      "options" => array("full image","with right description","with left description","with bottom description")
    ),     
    "num_excerpt" => array(
      "name" => "num_excerpt",
      "title" => "Number of Words for Slideshow Excerpt",
      "description" => "Add number of words excerpt to display in slideshow description, eg. 20",
      "type" => "text"
    )                       
  );
  
  return $meta_boxes;
}

function  slideshow_meta_boxes() {
  global $post, $key;
  $meta_boxes = vulcan_slideshow_meta_boxes();
  ?>

  <table class="form-table">
  <?php	 	
  wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );
  
  foreach($meta_boxes as $meta_box) {
  $data = get_post_meta($post->ID, $key, true);
  
		if ( $meta_box['type'] == 'text' )
			get_meta_text_input( $meta_box, $data[$meta_box['name']] );
		elseif ( $meta_box['type'] == 'select' )
			get_meta_select( $meta_box, $data[$meta_box['name']] );
    }
   ?>
  </table>
  <?php	 	
}

/* Add Meta Box for Post */
function vulcan_post_meta_boxes() {
  $meta_boxes = array(
    "thumb_image" => array(
      "name" => "thumb_image",
      "title" => "Thumbnail Image",
      "description" => "Add thumbnail image url, will be use for your post thumbnail, for example for your team image, blog thumbnail, client logo/image.",
      "type" => "text"
    ),
    "video_image_link" => array(
      "name" => "video_image_link",
      "title" => "Images / Video link",
      "description" => "please enter image or video url if you want to create video post.<br/>Images : <br />http://localhost/ovum/wp-content/uploads/2010/07/image.jpg<br/> Video : <br />
      http://www.youtube.com/watch?v=tESK9RcyexU<br />
      http://vimeo.com/12816548<br />
      http://localhost/vulcan/wp-content/uploads/2010/07/sample.3gp<br />
      http://localhost/vulcan/wp-content/uploads/2010/07/sample.mp4<br />
      http://localhost/vulcan/wp-content/uploads/2010/07/sample.mov<br />
      http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf?width=680&height=405<br />
      Note : for swf movie, you need to specify the width and height for movie, as above example",
      "type" => "text"
    ),    
  );
  
  return $meta_boxes;
}

function  post_meta_boxes() {
  global $post, $key;
  $meta_boxes = vulcan_post_meta_boxes();
  ?>

  <table class="form-table">
  <?php	 	
  wp_nonce_field( plugin_basename( __FILE__ ), $key . '_wpnonce', false, true );
  
  foreach($meta_boxes as $meta_box) {
  $data = get_post_meta($post->ID, $key, true);
  
		if ( $meta_box['type'] == 'text' )
			get_meta_text_input( $meta_box, $data[$meta_box['name']] );
    }
   ?>
  </table>
  <?php	 	
}

/* Populate Input Text */
function get_meta_text_input( $args = array(), $value = false ) { 
  extract($args);
  ?>
	<tr>
		<th style="width:10%;"><label for="<?php	 	 echo $args['name']; ?>"><?php	 	 echo $args['title']; ?></label></th>
		<td><input type="text" name="<?php	 	 echo $args['name']; ?>" id="<?php	 	 echo $args['name']; ?>" value="<?php	 	 echo wp_specialchars( $value, 1 ); ?>" size="30" tabindex="30" style="width: 97%;" />
    <br /><small><?php	 	 echo $args['description']; ?></small>
    </td>
	</tr>
	<?php	 	
}

/* Populate Textarea */
function get_meta_textarea( $args = array(), $value = false ) { 
  extract($args);
  ?>
	<tr>
		<th style="width:10%;"><label for="<?php	 	 echo $args['name']; ?>"><?php	 	 echo $args['title']; ?></label></th>
		<td><textarea name="<?php	 	 echo $args['name']; ?>" id="<?php	 	 echo $args['name']; ?>" cols="60" rows="4" tabindex="30" style="width: 97%;"><?php	 	 echo wp_specialchars( $value, 1 ); ?></textarea>
    <br /><small><?php	 	 echo $args['description']; ?></small>
    </td>
	</tr>
	<?php	 	
}

/* Populate Options Select */
function get_meta_select( $args = array(), $value = false ) { 
  extract($args);
  ?>
	<tr>
		<th style="width:10%;"><label for="<?php	 	 echo $args['name']; ?>"><?php	 	 echo $args['title']; ?></label></th>
		<td>
			<select name="<?php	 	 echo $args['name']; ?>" id="<?php	 	 echo $args['name']; ?>">
				<option value=""></option>
				<?php	 	 foreach ( $args['options'] as $option => $val ) : ?>
					<option <?php	 	 if ( htmlentities( $value, ENT_QUOTES ) == $val ) echo ' selected="selected"'; ?> value="<?php	 	 echo $val; ?>"><?php	 	 if ( __( 'Template:', 'hybrid') == $args['title'] ) echo $option; else echo $val; ?></option>
				<?php	 	 endforeach; ?>
			</select>
			<br /><small><?php	 	 echo $args['description']; ?></small>
		</td>
	</tr>
	<?php	 	
}

/* Create Meta Box for Post, Page and Custom Post Type */
function create_meta_box() {
  global $key;

  if( function_exists( 'add_meta_box' ) ) {
    add_meta_box( 'new-page-boxes', ' Page Options', 'page_meta_boxes', 'page', 'normal', 'high' );
    add_meta_box( 'new-portfolio-boxes', ' Portfolio Options', 'portfolio_meta_boxes', 'portfolio', 'normal', 'high' );
    add_meta_box( 'new-slideshow-boxes', ' Slideshow Options', 'slideshow_meta_boxes', 'slideshow', 'normal', 'high' );
    add_meta_box( 'new-post-boxes', ' Post Options', 'post_meta_boxes', 'post', 'normal', 'high' );
  }
}

/* Save Meta Box  */
function save_meta_box( $post_id ) {
  global $post, $key;
  
  if ( 'page' == $_POST['post_type'] )
		$meta_boxes = array_merge(vulcan_page_meta_boxes());
	elseif ( 'portfolio' == $_POST['post_type'] )
		$meta_boxes = array_merge(vulcan_portfolio_meta_boxes());
	elseif ( 'slideshow' == $_POST['post_type'] )
		$meta_boxes = array_merge(vulcan_slideshow_meta_boxes());		
	elseif ( 'post' == $_POST['post_type'] )
		$meta_boxes = array_merge(vulcan_post_meta_boxes());
                        
  if (is_array($meta_boxes )) {
   foreach( $meta_boxes as $meta_box ) {
     $data[ $meta_box[ 'name' ] ] = $_POST[ $meta_box[ 'name' ] ];
   }
  }
  
    if ( !wp_verify_nonce( $_POST[ $key . '_wpnonce' ], plugin_basename(__FILE__) ) )
    return $post_id;
  
    if ( 'page' == $_POST['post_type'] && !current_user_can( 'edit_page', $post_id ) )
    	return $post_id;
    	
    elseif ( 'portfolio' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
    	return $post_id;
    
    elseif ( 'slideshow' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
    	return $post_id;    	
    
    elseif ( 'post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
    	return $post_id;
    
    update_post_meta( $post_id, $key, $data );
}

add_action( 'admin_menu', 'create_meta_box' );
add_action( 'save_post', 'save_meta_box' );
