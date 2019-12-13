<?php

/**
  *  @package AlecadddPlugin
  */
namespace Inc\Base;

class Deactivate
{
	public static function deactivate(){
		flush_rewrite_rules();

		$options = array(
			'alecaddd_plugin',
			'alecaddd_plugin_cpt',
			'alecaddd_plugin_tax',
		);

		foreach( $options as $option ){
			delete_option( $option );
		}
	}
}