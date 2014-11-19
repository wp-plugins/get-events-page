<?php

/*
    Plugin Name: GetEvents Page for Wordpress
    Plugin URI: http://getevents.co/platforms/wordpress
    Description: The GetEvents Wordpress plugin will allow Wordpress users to simply connect their GetEvents account and create a new webpage on their website.
    Version: 2.0
    Author: GetEvents.co
    Author URI: http://getevents.co
    License: GPL
*/

define( 'GETEVENTS_DEBUG', FALSE );

define( 'GETEVENTS_MINIMUM_WP_VERSION', '3.0' );
define( 'GETEVENTS_VERSION', '2.0' );
define( 'GETEVENTS_SERVER', 'https://getevents.co' );
define( 'GETEVENTS__DB_USER_INFO', 'getevents_user_info' );
define( 'GETEVENTS__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'GETEVENTS__PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'GETEVENTS__PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'GETEVENTS__SHORTCODE', 'getevents' );

if (GETEVENTS_DEBUG) {
	require_once( GETEVENTS__PLUGIN_DIR . 'getevents-debug.php' );
}

require_once( GETEVENTS__PLUGIN_DIR . 'class.getevents-pages.php' );
require_once( GETEVENTS__PLUGIN_DIR . 'class.getevents-admin.php' );	


