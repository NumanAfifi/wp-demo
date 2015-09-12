<?php
/**
 * Events Calendar
 */

/** Register event post_type */
add_action( 'init', 'td_register_events', 0 );

function td_register_events() {

  $labels = array(
    'name'                => _x( 'Events', 'Post Type General Name', 't4e' ),
    'singular_name'       => _x( 'Event', 'Post Type Singular Name', 't4e' ),
    'menu_name'           => __( 'Events', 't4e' ),
    'name_admin_bar'      => __( 'Events', 't4e' ),
    'parent_item_colon'   => __( 'Parent Item:', 't4e' ),
    'all_items'           => __( 'All Events', 't4e' ),
    'add_new_item'        => __( 'Add New Event', 't4e' ),
    'add_new'             => __( 'Add New', 't4e' ),
    'new_item'            => __( 'New Event', 't4e' ),
    'edit_item'           => __( 'Edit Event', 't4e' ),
    'update_item'         => __( 'Update Event', 't4e' ),
    'view_item'           => __( 'View Event', 't4e' ),
    'search_items'        => __( 'Search Event', 't4e' ),
    'not_found'           => __( 'Not found', 't4e' ),
    'not_found_in_trash'  => __( 'Not found in Trash', 't4e' ),
  );
  $args = array(
    'label'               => __( 'Event', 't4e' ),
    'description'         => __( 'Events', 't4e' ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'custom-fields', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 5,
    'menu_icon'           => 'dashicons-calendar-alt',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => false,   
    'exclude_from_search' => true,
    'publicly_queryable'  => true,
    'capability_type'     => 'page',
  );
  register_post_type( 'event', $args );

}

/** Event metaboxes */
add_action( 'cmb2_init', 'td_events_calendar' );

function td_events_calendar() {

  $prefix = 'tdec_';

  // register metabox
  $cmb = new_cmb2_box(array(
    'id'            => $prefix . 'metabox',
    'title'         => __( 'Calendar Class Color', 'cmb2' ),
    'object_types'  => array( 'event'),
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
  ));

  // products select
  $products = array();
  $items = get_posts(array('post_type' => 'product'));
  foreach($items as $item) {
    $products[$item->ID] = $item->post_title;
  }
  wp_reset_postdata();

  $cmb->add_field( array(
      'name'     => __( 'Link to', 'cmb2' ),
      'id'       => $prefix . 'product',
      'type'     => 'select',
      'options'  => $products
  ) );

  // event dates
  $group_field_id = $cmb->add_field(array(
    'id'          => $prefix . 'dates',
    'type'        => 'group',
    'description' => __( 'Add your class sessions start dates and end dates below. To add additional click "Add New Date".', 'cmb2' ),
    'options'     => array(
      'group_title'   => __( 'Class Date {#}', 'cmb2' ),
      'add_button'    => __( 'Add New Date', 'cmb2' ),
      'remove_button' => __( 'Remove Entry', 'cmb2' ),
      'sortable'      => true,
    )
  ));

  $cmb->add_group_field($group_field_id, array(
    'name' => __( 'Start Date', 'cmb2' ),
    'id'   => 'start',
    'type' => 'text_datetime_timestamp',
  ));
  
  $cmb->add_group_field($group_field_id, array(
    'name' => __( 'End Date', 'cmb2' ),
    'id'   => 'end',
    'type' => 'text_datetime_timestamp',
  ));

  // event color
  $cmb->add_field(array(
    'name'    => __( 'Event Color', 'cmb2' ),
    'id'      => $prefix . 'color',
    'type'    => 'colorpicker',
    'default' => '#1e73be',
  ));
}

/** admin-ajax url */
add_action('wp_head', 'td_js_params');
function td_js_params() {
  ?>
  <script>
  var tdvars = {
    ajaxurl : "<?php echo admin_url('admin-ajax.php') ?>"
  }
  </script>
  <?php
}

/** Events API */
add_action('wp_ajax_td_events', 'td_events_api');
add_action('wp_ajax_nopriv_td_events', 'td_events_api');

function td_events_api() {
  $events = array();
  $start = isset($_GET['start']) ? $_GET['start'] : '';
  $end   = isset($_GET['end']) ? $_GET['end'] : '';

  $args = array(
    'post_type' => 'event'
  );

  $query = new WP_Query($args);

  if($query->have_posts()): while($query->have_posts()): $query->the_post();
    $parent = get_post(get_post_meta(get_the_ID(), 'tdec_product', true));
    $dates  = get_post_meta(get_the_ID(), 'tdec_dates', true);
    $color  = get_post_meta(get_the_ID(), 'tdec_color', true);

    if(is_array($dates)) {
      foreach($dates as $date) {
        $event = array(
          'title' => $parent->post_title,
          'start' => date('c', $date['start']),
          'end'   => date('c', $date['end']),
          'url'   => get_permalink($parent->ID),
          'backgroundColor' => $color
        );

        $events[] = $event;
      }
    }
  endwhile; endif;

  wp_reset_postdata();

  echo json_encode($events);
  die();
}


