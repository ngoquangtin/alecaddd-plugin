<?php

/**
 *  @package AlecadddPlugin
 */

namespace Inc\Base;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;

class CustomPostTypeController extends BaseController
{
	public $callbacks;

	public $cpt_callbacks;

	public $custom_post_types = array();

	public $subpages = array();

	public $settings;

	public function register()
	{
		$option = get_option( 'alecaddd_plugin' );
		$activated = isset( $option['cpt_manager'] ) && $option['cpt_manager'] ? true : false;

		if( ! $activated ){
			return;
		}

		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();
		$this->cpt_callbacks = new CptCallbacks();

		$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addSubPages( $this->subpages )->register();

		$this->storeCustomPostTypes();

		if( ! empty( $this->custom_post_types ) ){
			add_action( 'init', array( $this, 'registerCustomPostTypes' ) );
		}
	}

	public function storeCustomPostTypes()
	{
		if( ! get_option( 'alecaddd_plugin_cpt' ) ){
			return;
		}

		$options = get_option( 'alecaddd_plugin_cpt' );

		$this->custom_post_types = array();

		foreach( $options as $option ){
			$this->custom_post_types[] = array(
				'post_type' => $option['post_type'],
				'args' => array(
					'labels' => array(
						'name' => $option['plural_name'],
						'singular_name' => $option['singular_name'],
					),
					'public' => isset( $option['public'] ) ? true : false,
					'has_archive' => isset( $option['has_archive'] ) ? true : false,
				),
			);
		}
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'alecaddd_plugin_cpt_settings',
				'option_name'  => 'alecaddd_plugin_cpt',
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' ),
			),
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'alecaddd_cpt_index',
				'title' => 'Custom Post Types Manager',
				'callback' => array( $this->cpt_callbacks, 'cptSectionManager' ),
				'page' => 'alecaddd_cpt',
			),
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'post_type',
				'title' => 'Custom Post Type ID',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'alecaddd_cpt',
				'section' => 'alecaddd_cpt_index',
				'args' => array(
					'option_name' => 'alecaddd_plugin_cpt',
					'label_for' => 'post_type',
					'placeholder' => 'eg. products',
				),
			),

			array(
				'id' => 'singular_name',
				'title' => 'Singular Name',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'alecaddd_cpt',
				'section' => 'alecaddd_cpt_index',
				'args' => array(
					'option_name' => 'alecaddd_plugin_cpt',
					'label_for' => 'singular_name',
					'placeholder' => 'eg. Product',
				),
			),

			array(
				'id' => 'plural_name',
				'title' => 'Plural Name',
				'callback' => array( $this->cpt_callbacks, 'textField' ),
				'page' => 'alecaddd_cpt',
				'section' => 'alecaddd_cpt_index',
				'args' => array(
					'option_name' => 'alecaddd_plugin_cpt',
					'label_for' => 'plural_name',
					'placeholder' => 'eg. Products',
				),
			),

			array(
				'id' => 'public',
				'title' => 'Public',
				'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
				'page' => 'alecaddd_cpt',
				'section' => 'alecaddd_cpt_index',
				'args' => array(
					'option_name' => 'alecaddd_plugin_cpt',
					'label_for' => 'public',
					'class' => 'ui-toggle',
				),
			),

			array(
				'id' => 'has_archive',
				'title' => 'Archive',
				'callback' => array( $this->cpt_callbacks, 'checkboxField' ),
				'page' => 'alecaddd_cpt',
				'section' => 'alecaddd_cpt_index',
				'args' => array(
					'option_name' => 'alecaddd_plugin_cpt',
					'label_for' => 'has_archive',
					'class' => 'ui-toggle',
				),
			),
		);

		$this->settings->setFields( $args );
	}

	public function registerCustomPostTypes()
	{
		foreach( $this->custom_post_types as $post_type ){
			register_post_type( $post_type['post_type'], $post_type['args'] );
		}
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'alecaddd_plugin',
				'page_title' => 'Custom Post Types',
				'menu_title' => 'CPT Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'alecaddd_cpt',
				'callback' => array( $this->callbacks, 'adminCPT' ),
			),
		);
	}

}