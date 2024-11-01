<?php
/**
 * Plugin Name:	WP Scroll To Post
 * Plugin URI:	http://wordpress.org/plugins/wp-scroll-to-post/
 * Description:	This plugin will show post randomly at the bottom right corner when scroll your browser document.
 * Version:		1.1
 * Author:		Hossni Mubarak
 * Author URI:	http://www.hossnimubarak.com
 * License:		GPL-2.0+
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WSP_PATH', plugin_dir_path( __FILE__ ) );
define( 'WSP_ASSETS', plugins_url( '/assets/', __FILE__ ) );
define( 'WSP_LANG', plugins_url( '/languages/', __FILE__ ) );
define( 'WSP_SLUG', plugin_basename( __FILE__ ) );
define( 'WSP_PRFX', 'wsp_' );
define( 'WSP_CLS_PRFX', 'cls-wp-scroll-post' );
define( 'WSP_TXT_DOMAIN', 'wp-scroll-post' );
define( 'WSP_VERSION', '1.1' );

require_once WSP_PATH . 'inc/' . WSP_CLS_PRFX . '-master.php';
$wsp = new WSP_Master();
$wsp->wsp_run();
register_deactivation_hook( __FILE__, array($wsp, WSP_PRFX . 'unregister_settings') );
