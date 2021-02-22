<?php
/**
 * NewCity Custom Shortcodes Features
 *
 *
 * @since             0.1.0
 * @package           NewCity_WYSIWYG
 *
 * @wordpress-plugin
 * Plugin Name:       NewCity Custom WYSIWYG tools
 * * Plugin URI: https://github.com/newcity/newcity-wp-wysiwyg
 * Description:       Custom toolbars and modifications to TinyMCE
 * Version:           0.2.4
 * Author:            NewCity  <geeks@insidenewcity.com>
 * Author URI:        http://insidenewcity.com
 * License:           NONE
 */


 // If this file is called directly, abort.
 if ( ! defined( 'WPINC' ) ) {
     die;
 }

require_once( dirname( __FILE__ ) . '/class-newcity-toolbars.php');

function newcity_wysiwyg_run() {
	$brpa_filters = new NewCityToolbars();
}

newcity_wysiwyg_run();
