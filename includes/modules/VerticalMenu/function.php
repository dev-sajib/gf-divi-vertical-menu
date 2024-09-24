<?php

// Include this in your plugin's main PHP file (e.g., plugin-name.php)

add_action('wp_ajax_get_all_posts', 'myplugin_get_all_posts');  // For logged-in users
add_action('wp_ajax_nopriv_get_all_posts', 'myplugin_get_all_posts');  // For non-logged-in users

function myplugin_get_all_posts() {
  // Check if the action is triggered
  if (isset($_POST['action']) && $_POST['action'] === 'get_all_posts') {
      // Debugging: Simple log message
      error_log('Ajax action get_all_posts is triggered');
      
      // Prepare a simple test response
      $response = array(
          'message' => 'Ajax request is working!',
          'posts'   => []
      );
      
      wp_send_json($response);
  } else {
      wp_send_json_error('Invalid request');
  }

  wp_die();  // Always call wp_die() after an Ajax handler
}
