<?php

/**
  *  @package AlecadddPlugin
  */

/*
Plugin Name: Alecaddd Plugin
Plugin URI: http://alecaddd.com/plugins
Description: This is my first attempt on writing a custom plugin for this amazing tutorial series.
Version: 1.0.0
Author: Alessandro Castellani
Author URI: http://alecaddd.com/
License: GPLv2 or later
Text Domain: alecaddd-plugin
*/

/*
	License Text
*/

defined('ABSPATH') or die('What are you doing here? You silly human!');

if( file_exists( dirname(__FILE__) . '/vendor/autoload.php' ) ){
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

function activate_alecaddd_plugin(){
	Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_alecaddd_plugin' );

function deactivate_alecaddd_plugin(){
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_alecaddd_plugin' );

if( class_exists( 'Inc\\Init' ) ){
	Inc\Init::register_services();
}
