<?php

/**
 * @package AlecadddPlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class TaxonomyCallbacks extends BaseController
{

	public function taxSanitize( $input )
	{
		$output = get_option( 'alecaddd_plugin_tax' );

		if( isset( $_POST['remove'] ) ){
			unset( $output[ $_POST['remove'] ] );
			return $output;
		}

		$input['hierarchical'] = isset( $input['hierarchical'] ) ? 1 : 0;

		$output[ $input['taxonomy'] ] = $input;

		return $output;
	} 

	public function taxSectionManager()
	{
		echo 'Create as many Taxonomies as you want.';
	}

	public function textField( $args )
	{
		$option_name = $args['option_name'];
		$name = $args['label_for'];
		$value = '';

		if( isset( $_POST['edit_taxonomy'] ) ){
			$input = get_option( $option_name );
			$value = $input[ $_POST['edit_taxonomy'] ][$name];
		}

		echo '<input type="text" class="regular-text" id="'.$name.'" name="'.$option_name.'['.$name.']" placeholder="'.$args['placeholder'].'" value="'.$value.'" />';
	}

	public function checkboxField( $args )
	{
		$option_name = $args['option_name'];
		$name = $args['label_for'];
		$classes = $args['class'];
		$checked = false;

		if( isset( $_POST['edit_taxonomy'] ) ){
			$input = get_option( $option_name );
			$checked = isset( $input[ $_POST['edit_taxonomy'] ][$name] ) && $input[ $_POST['edit_taxonomy'] ][$name] ? true : false;
		}

		echo '<div class="'.$classes.'"><input type="checkbox" id="'.$name.'" name="'.$option_name.'['.$name.']" value="1" '. ($checked ? 'checked' : '') .' /><label for="'.$name.'"><div></div></label></div>';
	}

	public function checkboxPostTypesField( $args )
	{
		$output = '';

		$option_name = $args['option_name'];
		$name = $args['label_for'];
		$classes = $args['class'];
		$checked = false;

		if( isset( $_POST['edit_taxonomy'] ) ){
			$checkbox = get_option( $option_name );
		}

		$post_types = get_post_types( array( 'show_ui' => true ) );

		#$this->al_print_r( $post_types, true );
		foreach( $post_types as $post ){

			if( isset( $_POST['edit_taxonomy'] ) ){
				$checked = isset( $checkbox[ $_POST['edit_taxonomy'] ][$name][$post] ) ? true : false;
			}

			$output .= '<div class="'.$classes.' mb-10"><input type="checkbox" id="'.$post.'" name="'.$option_name.'['.$name.']['.$post.']" value="1" '. ($checked ? 'checked' : '') .' /><label for="'.$post.'"><div></div></label> <strong>'.$post.'</strong></div>';
		}

		#echo '<div class="'.$classes.'"><input type="checkbox" id="'.$name.'" name="'.$option_name.'['.$name.']" value="1" '. ($checked ? 'checked' : '') .' /><label for="'.$name.'"><div></div></label></div>';

		echo $output;
	}

}
