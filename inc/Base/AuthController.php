<?php

/**
 *  @package AlecadddPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;

class AuthController extends BaseController
{

	public function register()
	{
		if( ! $this->activated( 'login_manager' ) ){
			return;
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_head', array( $this, 'add_auth_template' ) );
	}

	public function enqueue()
	{
		if( is_user_logged_in() ){
			return;
		}

		wp_enqueue_style( 'authStyle', $this->plugin_url . 'assets/auth.css', array(), '1.0.0' );
		wp_enqueue_script( 'authScript', $this->plugin_url . 'assets/auth.js', array(), '1.0.0' );
	}

	public function add_auth_template()
	{
		if( is_user_logged_in() ){
			return;
		}

		$file = $this->plugin_path . 'templates/auth.php';

		if( file_exists( $file ) ){
			load_template( $file, true );
		}
	}

}
			