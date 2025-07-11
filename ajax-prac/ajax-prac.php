<?php
/*
* Plugin Name:       Ajax Practice
* Plugin URI:        devabdurrahman.com
* Description:       A prcatice plugin for Ajax.
* Version:           1.0
* Requires at least: 5.2
* Requires PHP:      7.2
* Author:            Abdur Rahman
* Author URI:        devabdurrahman.com
* License:           GPL v2 or later
* License URI:       https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain:       ajax-prac
* Domain Path:       /languages
*/

// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function mytheme_enqueue_scripts() {
    wp_enqueue_script('my-ajax-script', plugin_dir_url(__FILE__) . '/js/my-ajax.js', array('jquery'), null, true);

    // Send admin-ajax.php URL and nonce to JS
    wp_localize_script('my-ajax-script', 'my_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('my_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_scripts');


function load_random_post_title_callback() {
    check_ajax_referer('my_ajax_nonce', 'security');

    $post = get_posts(array('numberposts' => 1, 'orderby' => 'rand'));
    if (!empty($post)) {
        echo esc_html($post[0]->post_title);
    } else {
        echo 'No post found.';
    }

    wp_die(); // Required to end AJAX requests
}

add_action('wp_ajax_load_random_post_title', 'load_random_post_title_callback'); // Logged-in users
add_action('wp_ajax_nopriv_load_random_post_title', 'load_random_post_title_callback'); // Visitors