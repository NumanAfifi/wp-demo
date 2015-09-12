<?php 
/**
 * Initialise core functionalities
 */

/** Add RSS to the <head> section */
add_theme_support( 'automatic-feed-links' );

/** Add title tag support */
add_theme_support('title-tag');

/** Post thumbnails functionality */
add_theme_support('post-thumbnails'); 
set_post_thumbnail_size( 100, 100, true );
add_image_size( 'single-post-thumbnail', 400, 300 );

/** Register Navigation Menus */
register_nav_menus(
  array(
    'primary'=>__('Primary Menu'),
  )
);

/** Register sidebars */
register_sidebar( array(
  'name' => 'Primary Sidebar',
  'id'   => 'sidebar',
  'description'   => 'Widgets for the Primary Sidebar',
  'before_widget' => '<div id="%1$s" class="widget %2$s">',
  'after_widget'  => '</div><!-- .widget -->',
  'before_title'  => '<h4>',
  'after_title'   => '</h4>'
));

/** Set content width */
if ( ! isset( $content_width ) ) $content_width = 860;

add_filter('locale', function($lang) { 
  if( is_admin() ) {
    return 'en_US';
  }
  return $lang;
});

/** fix chrome */
function chromefix_inline_css()
{ 
  if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Chrome' ) !== false )
  {
    wp_add_inline_style( 'wp-admin', '#adminmenu { transform: translateZ(0); }' );
  }
}

add_action('admin_enqueue_scripts', 'chromefix_inline_css');