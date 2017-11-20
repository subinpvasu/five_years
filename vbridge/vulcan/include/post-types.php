<?php
/* Register Custom Post Type for Portfolio */
add_action('init', 'portfolio_post_type_init');
function portfolio_post_type_init() {
  $labels = array(
    'name' => _x('Portfolio', 'post type general name'),
    'singular_name' => _x('portfolio', 'post type singular name'),
    'add_new' => _x('Add New', 'portfolio'),
    'add_new_item' => __('Add New portfolio'),
    'edit_item' => __('Edit portfolio'),
    'new_item' => __('New portfolio'),
    'view_item' => __('View portfolio'),
    'search_items' => __('Search portfolio'),
    'not_found' =>  __('No portfolio found'),
    'not_found_in_trash' => __('No portfolio found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'rewrite' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'show_in_nav_menus' => false,
    'menu_position' => 1000,
    'supports' => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'excerpt',
      'comments',
      'thumbnail',
      'trackbacks',
      'custom-fields',
      'revisions'       
    )
  );
  register_post_type('portfolio',$args);
}

/* Register Custom Post Type for Slideshow */
add_action('init', 'slideshow_post_type_init');
function slideshow_post_type_init() {
  $labels = array(
    'name' => _x('Slideshow', 'post type general name'),
    'singular_name' => _x('slideshow', 'post type singular name'),
    'add_new' => _x('Add New', 'slideshow'),
    'add_new_item' => __('Add New slideshow'),
    'edit_item' => __('Edit slideshow'),
    'new_item' => __('New slideshow'),
    'view_item' => __('View slideshow'),
    'search_items' => __('Search slideshow'),
    'not_found' =>  __('No slideshow found'),
    'not_found_in_trash' => __('No slideshow found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'rewrite' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'show_in_nav_menus' => false,
    'menu_position' => 1000,
    'supports' => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'excerpt',
      'comments',
      'thumbnail',
      'trackbacks',
      'custom-fields',
      'revisions'       
    )
  );
  register_post_type('slideshow',$args);
}
?>