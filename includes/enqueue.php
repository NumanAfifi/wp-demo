<?php
/**
 * Enqueue CSS & JS scripts
 */

class TD_Enqueue {

  protected $version;

  protected $styles = array(
    'bootstrap-css'    => 'packages/bootstrap.css',
    // 'fullcalendar-css' => 'packages/fullcalendar.css',
    'style'            => 'style.css',
  );

  protected $scripts = array(
    'bootstrap-js'     => 'packages/bootstrap.js',
    // 'moment-js'        => 'packages/moment.js',
    // 'fullcalendar-js'  => 'packages/fullcalendar.js',
    'scripts'          => 'assets/javascripts/scripts.js',
  );

  function __construct() {
    $this->version();
    add_action('wp_enqueue_scripts', array($this, 'register'));
  }

  function version() {
    $theme = wp_get_theme();
    $this->version = $theme->get('Version');

    add_action('init', array($this, 'register'));
    add_action('wp_enqueue_scripts', array($this, 'enqueue'));
    add_action('template_redirect', array($this, 'singular'));
  }

  function register() {

    foreach($this->styles as $key => $value) {
      $path = $value;
      wp_register_style($key, trailingslashit(get_stylesheet_directory_uri()).$path, $this->version);
    }

    foreach($this->scripts as $key => $value) {
      if(is_array($value)) {
        $path = $value['path'];
        $deps = $value['deps'];
      } else {
        $path = $value;
        $deps = array('jquery');
      }

      wp_register_script($key, trailingslashit(get_stylesheet_directory_uri()).$path, $deps, $this->version);
    }
  }

  function enqueue() {
    wp_enqueue_script('jquery');

    foreach($this->styles as $key => $value) {
      wp_enqueue_style($key);
    }

    foreach($this->scripts as $key => $value) {
      wp_enqueue_script($key);
    }
  }

  function singular() {
    if ( is_singular() ) {
      wp_enqueue_script('comment-reply');
    }
  }

}

new TD_Enqueue;