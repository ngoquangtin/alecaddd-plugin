<?php

/**
 * @package AlecadddPlugin
 */

namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
	public function adminDashboard()
	{
		require_once "$this->plugin_path/templates/admin.php";
	}

	public function adminCPT()
	{
		require_once "$this->plugin_path/templates/cpt.php";
	}

	public function adminTaxonomy()
	{
		require_once "$this->plugin_path/templates/taxonomy.php";
	}

	public function adminTestimonial()
	{
		require_once "$this->plugin_path/templates/testimonial.php";
	}

/*
	public function alecadddOptionsGroup( $input )
	{
		return $input;
	}

	public function alecadddAdminSection()
	{
		echo 'Check this beautiful section.';
	}
*/

	public function alecadddTextExample()
	{
		$value = esc_attr( get_option( 'text_example' ) );
		echo '<input type="text" class="regular-text" name="text_example" value="' . $value . '" placeholder="Write Something ..." />';
	}

	public function alecadddFirstName()
	{
		$value = esc_attr( get_option( 'first_name' ) );
		echo '<input type="text" class="regular-text" name="first_name" value="' . $value . '" placeholder="Write Your First Name ..." />';
	}
}
