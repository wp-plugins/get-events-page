<?php

/*
    Plugin Name: GetEvents Page for Wordpress
    Plugin URI: http://getevents.co/platforms/wordpress
    Description: The GetEvents Wordpress plugin will allow Wordpress users to simply connect their GetEvents account and create a new webpage on their website.
    Version: 1.0
    Author: GetEvents.co
    Author URI: http://getevents.co
    License: GPL
*/

add_action( 'admin_init', 'getevents_plugin_admin_init' );

// Connect GetEvents with Wordpress

add_action( 'admin_init', 'getevents_plugin_connect_account' );

function getevents_plugin_connect_account() {
    include 'getevents_plugin_connect_account.php';
}


// Sigin to GetEvents from Wordpress

add_action( 'admin_init', 'getevents_plugin_sign_in' );

function getevents_plugin_sign_in() {
    include 'getevents_plugin_sign_in.php';
}


// Add a short code to be used on all of the pages

add_shortcode( 'getevents', 'getevents_add_shortcode' );

function getevents_add_shortcode( $atts ) {
    $geteventsOptionAccount = 'getevents_account';
    $data = get_option( $geteventsOptionAccount );
    return stripslashes($data['script']);
}

// Display the plugin..,

function getevents_plugin_admin_init() {
    wp_register_script( 'getevents-plugin-script', plugins_url( 'js/getevents.js', __FILE__ ) );
    wp_register_style( 'getevents-style-css', plugins_url( 'css/getevents.css', __FILE__ ) );
}

function getevents_plugin_admin_scripts() {
    wp_enqueue_script( 'getevents-plugin-script' );
}

function getevents_plugin_admin_styles() {
    wp_enqueue_style( 'getevents-style-css' );
}

add_action( 'admin_menu', 'getevents_admin_menu' );

function getevents_admin_menu() {
    $page_hook_suffix = add_menu_page(
        "GetEvents",
        "GetEvents",
        "manage_options",
        __FILE__,
        "getevents_admin_options",
        plugin_dir_url( __FILE__ ) . "/images/icon.png",
        21
    );
    add_action( 'admin_print_scripts-' . $page_hook_suffix, 'getevents_plugin_admin_scripts' );
    add_action( 'admin_print_styles-' . $page_hook_suffix, 'getevents_plugin_admin_styles' );
}

function getevents_admin_options() {
    include 'getevents_admin_options.php';
}



?>
