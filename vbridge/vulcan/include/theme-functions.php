<?php	 	

/* Theme Functions  */

/* Content Excerpt Function */
function excerpt($excerpt_length) {
  global $post;
	$content = strip_shortcodes($post->post_content);
	$words = explode(' ', $content, $excerpt_length + 1);
	if(count($words) > $excerpt_length) :
		array_pop($words);
		array_push($words, '');
		$content = implode(' ', $words);
	endif;
  
  $content = strip_tags($content);
  
	echo $content;
}

/* Comment Function */
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
      <div class="comment-<?php	 	 comment_ID() ?>">
        <div class="comment-post">
          <div class="avatar"><?php	 	 echo get_avatar($comment,$size='60'); ?></div>
          <div class="comment-text">
          <h5><?php	 	 comment_author_link() ?></h5>
          <div class="comment-date"><?php	 	 comment_date('F jS, Y') ?> on <?php	 	 comment_time() ?></div>
          <?php	 	 if ($comment->comment_approved == '0') : ?>
    		<p>Your comment is awaiting moderation.</p>
    		<?php	 	 endif; ?>

          <?php	 	 comment_text() ?>
          <div class="clr"></div>
            <div class="reply">
               <?php	 	 comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>  			
          </div>
        </div>
			</div>
<?php	 	
}

function mytheme_ping($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
      <div class="commentlist" id="comment-<?php	 	 comment_ID() ?>">
			<div class="grid_1 listcomment alpha" >
        <?php	 	 echo get_avatar($comment,$size='60'); ?>
      </div>
		  <div class="placecomment grid_6">
				<h6><?php	 	 comment_author_link() ?>, <?php	 	 comment_date('F jS, Y') ?> on <?php	 	 comment_time() ?></h6>
  		<?php	 	 if ($comment->comment_approved == '0') : ?>
    		<p>Your comment is awaiting moderation.</p>
    		<?php	 	 endif; ?>
    		<?php	 	 comment_text() ?>
    		<div class="clear"></div>
        <div class="reply">
           <?php	 	 comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div>  			
			</div>
			<div class="clear"></div>
		</div>
<?php	 	
}

/* Insert Javascript Library to Head Section */
function vulcan_add_javascripts() {
  wp_enqueue_scripts('jquery');
  wp_enqueue_script( 'jquery.cycle.all', get_bloginfo('template_directory').'/js/jquery.cycle.all.js', array( 'jquery' ) );
  wp_enqueue_script( 'jquery.corner', get_bloginfo('template_directory').'/js/jquery.corner.js', array( 'jquery' ) );
  wp_enqueue_script( 'jqueryslidemenu', get_bloginfo('template_directory').'/js/jqueryslidemenu.js', array( 'jquery' ) );
  wp_enqueue_script( 'jquery.prettyPhoto', get_bloginfo('template_directory').'/js/jquery.prettyPhoto.js', array( 'jquery' ) );
  wp_enqueue_script('functions', get_bloginfo('template_directory').'/js/functions.js', array('jquery'));
}

if (!is_admin()) {
  add_action( 'wp_print_scripts', 'vulcan_add_javascripts' ); 
}

/* Add Javascript For Admin Theme Options Tabs */
function vulcan_admin_add_javascripts() {
  wp_enqueue_script('jquery.tools.min', get_bloginfo('template_directory').'/js/tabs/jquery.tools.min.js', array('jquery'), '0.5');
}
if (is_admin()) {
  add_action( 'wp_print_scripts', 'vulcan_admin_add_javascripts' );
}

/* Custom Styling for Theme Scheme Options */
function vulcan_add_stylesheet() { 
  $vulcan_style = get_option('vulcan_style');  
  ?>
	<!--<link rel="stylesheet" href="<?php	 	 bloginfo('template_directory'); ?>/css/jqueryslidemenu.css" type="text/css" media="screen" />-->
	<link rel="stylesheet" href="<?php	 	 bloginfo('template_directory'); ?>/css/prettyPhoto.css" type="text/css" media="screen" />
	<?php	 	 if ($vulcan_style) { ?>
	 <link rel="stylesheet" href="<?php	 	 bloginfo('template_directory'); ?>/css/styles/<?php	 	 echo $vulcan_style; ?>" type="text/css" media="screen" />
	<?php	 	 }
}

add_action('wp_head', 'vulcan_add_stylesheet');

/* Register Nav Menu Features For Wordpress 3.0 */
register_nav_menus( array(
	'topnav' => __( 'Main Navigation'),
	'footernav' => __( 'Footer Navigation'),
) );

/* Native Nagivation Pages List for Main Menu */
function vulcan_topmenu_pages() {
  global $excludeinclude_pages;
  
  $excludeinclude_pages = get_option('vulcan_excludeinclude_pages');
  if(is_array($excludeinclude_pages)) {
    $page_exclusions = implode(",",$excludeinclude_pages);
  }
?>
	<ul class="navigation">
  	<li <?php	 	 if (is_home() || is_front_page()) echo 'class="current"';?>><a href="<?php	 	 bloginfo('url');?>">Home</a></li>
  	<?php	 	 wp_list_pages('title_li=&sort_column=menu_order&depth=4&exclude='.$page_exclusions);?>
  </ul>

<?php	 	
}

/* Native Nagivation Pages List for Footer Menu */
function vulcan_footermenu_pages() {
  global $excludeinclude_pages;
  
  $excludeinclude_pages = get_option('vulcan_excludeinclude_pages');
  if(is_array($excludeinclude_pages)) {
    $page_exclusions = implode(",",$excludeinclude_pages);
  }
?>
	<ul class="navigation-footer">
  	<li <?php	 	 if (is_home() || is_front_page()) echo 'class="current"';?>><a href="<?php	 	 bloginfo('url');?>">Home</a></li>
  	<?php	 	 wp_list_pages('title_li=&sort_column=menu_order&depth=1&exclude='.$page_exclusions);?>
  </ul>

<?php	 	
}

/* Remove Default Container for Nav Menu Features */
function vulcan_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
} 
add_filter( 'wp_nav_menu_args', 'vulcan_nav_menu_args' );

/* Get vimeo Video ID */
function vimeo_videoID($url) {
	if ( 'http://' == substr( $url, 0, 7 ) ) {
		preg_match( '#http://(www.vimeo|vimeo)\.com(/|/clip:)(\d+)(.*?)#i', $url, $matches );
		if ( empty($matches) || empty($matches[3]) ) return __('Unable to parse URL', 'ovum');

		$videoid = $matches[3];
		return $videoid;
	}
}

function youtube_videoID($url) {
	preg_match( '#http://(www.youtube|youtube|[A-Za-z]{2}.youtube)\.com/(watch\?v=|w/\?v=|\?v=)([\w-]+)(.*?)#i', $url, $matches );
	if ( empty($matches) || empty($matches[3]) ) return __('Unable to parse URL', 'ovum');
  
  $videoid = $matches[3];
	return $videoid;
}

function get_shortcode_name($name) {
  if (strstr(get_shortcode_regex(),$name)) {
    return true;
  }
}

        
function detect_ext($file) {
  $ext = pathinfo($file, PATHINFO_EXTENSION);
  return $ext;
}

function is_quicktime($file) {
  $quicktime_file = array("mov","3gp","mp4");
  if (in_array(pathinfo($file, PATHINFO_EXTENSION),$quicktime_file)) {
    return true;
  } else {
    return false;
  }
}

function is_flash($file) {
  if (pathinfo($file, PATHINFO_EXTENSION) == "swf") {
    return true;
  } else {
    return false;
  }
}

function is_youtube($file) {
  if (preg_match('/youtube/i',$file)) {
    return true;
  } else {
    return false;
  }
}

function is_vimeo($file) {
  if (preg_match('/vimeo/i',$file)) {
    return true;
  } else {
    return false;
  }
}

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'vulcan', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );
?>
