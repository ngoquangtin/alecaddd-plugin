<?php

/**
  *  @package AlecadddPlugin
  */
namespace Inc\Base;

class Activate
{
	public static function activate(){
		flush_rewrite_rules();

		$options = array(
			'alecaddd_plugin',
			'alecaddd_plugin_cpt',
			'alecaddd_plugin_tax',
		);

		$default = array();

		foreach( $options as $option ){
			if( ! get_option( $option ) ){
				update_option( $option, $default );
			}			
		}
	}
}