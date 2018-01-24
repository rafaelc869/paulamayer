<?php
/**
 * Plugin Name: WP Logo Showcase
 * Plugin URI: https://radiustheme.com/
 * Description: Fully Responsive and Mobile Friendly way to display your partner logo in different view.
 * Author: RadiusTheme
 * Version: 2.1.2
 * Text Domain: wp-logo-showcase
 * Domain Path: /languages
 * Author URI: https://radiustheme.com/
 */
if ( ! defined( 'ABSPATH' ) )  exit;

define('RT_WLS_PLUGIN_PATH', dirname(__FILE__));
define('RT_WLS_PLUGIN_ACTIVE_FILE_NAME', __FILE__);
define('RT_WLS_PLUGIN_URL', plugins_url('', __FILE__));
define('RT_WLS_PLUGIN_SLUG', basename( dirname( __FILE__ ) ));
define('RT_WLS_PLUGIN_LANGUAGE_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages');

require ('lib/init.php');