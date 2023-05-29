<?php

/**
 * @package OSS117 Hello
 * @version 1.0
 */
/*
Plugin Name: OSS117 Hello
Description: Ce plugin affiche une citation d'OSS117 dans le coin supérieur droit de votre écran d'administration sur chaque page, afin de vous remonter le moral et vous rappeler que OSS117 est toujours là pour vous.
Author: Kenny Caldieraro
Version: 1.0
Author URI: https://webplayground.fr
*/

function getQuote()
{
    $api_url = 'https://oss117.click/api/v1/quote/random';
    $api_response = wp_remote_get($api_url);
    $api_body = wp_remote_retrieve_body($api_response);
    $api_data = json_decode($api_body);
    return $api_data->content;
}

function editAdminBar()
{
    global $wp_admin_bar;
    $quote = getQuote();
    $args = array(
        'id' => 'oss117-hello',
        'meta' => array('class' => 'oss117-hello'),
        'title' => '<a class="ab-item-link" href="https://oss117.click" target="_blank">' . wp_trim_words($quote, 25, '...') . '</a>'
    );
    $wp_admin_bar->add_node($args);
}

function custom_admin_menu_style()
{
    wp_enqueue_style('custom-admin-menu-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
}

add_action('admin_bar_menu', 'editAdminBar', 999);
add_action('admin_enqueue_scripts', 'custom_admin_menu_style');
