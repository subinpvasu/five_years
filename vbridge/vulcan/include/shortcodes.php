<?php	 	

/* List Styles */
function vulcan_bullelist( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="circle">', do_shortcode($content));
	return $content;
	
}
add_shortcode('bulletlist', 'vulcan_bullelist');

function vulcan_arrowlist( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="arrow">', do_shortcode($content));
	return $content;	
}
add_shortcode('arrowlist', 'vulcan_arrowlist');

function vulcan_checklist( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="checklist">', do_shortcode($content));
	return $content;	
}
add_shortcode('checklist', 'vulcan_checklist');

function vulcan_orderlist( $atts, $content = null ) {
	$content = str_replace('<ol>', '<ol>', do_shortcode($content));
	return $content;	
}
add_shortcode('orderlist', 'vulcan_orderlist');


/* Messages Box */

function vulcan_warningbox( $atts, $content = null ) {
   return '<div class="warning">' . do_shortcode($content) . '</div>';
}
add_shortcode('warning', 'vulcan_warningbox');


function vulcan_infobox( $atts, $content = null ) {
   return '<div class="info">' . do_shortcode($content) . '</div>';
}
add_shortcode('info', 'vulcan_infobox');

function vulcan_successbox( $atts, $content = null ) {
   return '<div class="success">' . do_shortcode($content) . '</div>';
}
add_shortcode('success', 'vulcan_successbox');

function vulcan_errorbox( $atts, $content = null ) {
   return '<div class="error">' . do_shortcode($content) . '</div>';
}
add_shortcode('error', 'vulcan_errorbox');

/* Highlight */
function vulcan_highlight_yellow( $atts, $content = null ) {
   return '<span class="highlight-yellow">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight_yellow', 'vulcan_highlight_yellow');

function vulcan_highlight_dark( $atts, $content = null ) {
   return '<span class="highlight-dark">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight_dark', 'vulcan_highlight_dark');

function vulcan_highlight_green( $atts, $content = null ) {
   return '<span class="highlight-green">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight_green', 'vulcan_highlight_green');

function vulcan_highlight_red( $atts, $content = null ) {
   return '<span class="highlight-red">' . do_shortcode($content) . '</span>';
}
add_shortcode('highlight_red', 'vulcan_highlight_red');



//************************************* Pullquotes

function vulcan_pullquote_right( $atts, $content = null ) {
   return '<span class="pullquote_right">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote_right', 'vulcan_pullquote_right');


function vulcan_pullquote_left( $atts, $content = null ) {
   return '<span class="pullquote_left">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote_left', 'vulcan_pullquote_left');

function vulcan_italic_text( $atts, $content = null ) {
   return '<p class="italictext">' . do_shortcode($content) . '</p>';
}
add_shortcode('italic_text', 'vulcan_italic_text');


/* Dropcap */
function vulcan_drop_cap( $atts, $content = null ) {
   return '<span class="dropcap">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap', 'vulcan_drop_cap');

/* Full Column */
function vulcan_fullwidthpage($atts, $content = null ) {
   return '<div class="page">' . do_shortcode($content) . '</div>';
}
add_shortcode('fullwidthpage', 'vulcan_fullwidthpage');

/* Button */

function vulcan_button_red( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'      => '#',
    ), $atts));

	$out = "<a class=\"button-red\" href=\"" .$link. "\"><span>" .do_shortcode($content). "</span></a>";
    
    return $out;
}
add_shortcode('button_red', 'vulcan_button_red');

function vulcan_button_grey( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'      => '#',
    ), $atts));

	$out = "<a class=\"button2\" href=\"" .$link. "\"><span>" .do_shortcode($content). "</span></a>";
    
    return $out;
}
add_shortcode('button_grey', 'vulcan_button_grey');

function vulcan_button_blue( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'      => '#',
    ), $atts));

	$out = "<a class=\"button-blue\" href=\"" .$link. "\"><span>" .do_shortcode($content). "</span></a>";
    
    return $out;
}
add_shortcode('button_blue', 'vulcan_button_blue');

/* Images */
function vulcan_image_source( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'image_url'      => '#',
        'class'      => 'imgleft',
    ), $atts));

	$out = "<img src=\"" .$image_url. "\" alt=\"\" class=\"".$class."\"/ >";
    
    return $out;
}
add_shortcode('image_source', 'vulcan_image_source');

#### Vimeo eg http://vimeo.com/5363880 id="5363880"
function vimeo_code($atts,$content = null){

	extract(shortcode_atts(array(  
		"id" 		=> '',
		"width"		=> $width, 
		"height" 	=> $height
	), $atts)); 
	 
	$data = "<object
		width='$width'
		height='$height'
		data='http://vimeo.com/moogaloop.swf?clip_id=$id&amp;server=vimeo.com'
		type='application/x-shockwave-flash'>
			<param name='allowfullscreen' value='true' />
			<param name='allowscriptaccess' value='always' />
			<param name='wmode' value='opaque'>
			<param name='movie' value='http://vimeo.com/moogaloop.swf?clip_id=$id&amp;server=vimeo.com' />
		</object>";
	return $data;
} 
add_shortcode("vimeo_video", "vimeo_code"); 

#### YouTube eg http://www.youtube.com/v/MWYi4_COZMU&hl=en&fs=1& id="MWYi4_COZMU&hl=en&fs=1&"
function youTube_code($atts,$content = null){

	extract(shortcode_atts(array(  
      "id" 		=> '',
  		"width"		=> $width, 
  		"height" 	=> $height
		 ), $atts)); 
	 
	$data = "<object
		width='$width'
		height='$height'
		data='http://www.youtube.com/v/$id' 
		type='application/x-shockwave-flash'>
			<param name='allowfullscreen' value='true' />
			<param name='allowscriptaccess' value='always' />
			<param name='FlashVars' value='playerMode=embedded' />
			<param name='wmode' value='opaque'>
			<param name='movie' value='http://www.youtube.com/v/$id' />
		</object>";
	return $data;
} 
add_shortcode("youtube_video", "youTube_code");

?>