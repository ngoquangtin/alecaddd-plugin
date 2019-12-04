<?php

/**
  *  @package AlecadddPlugin
  */

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ){
	die;
}
/*
$books = get_posts( array( 'post_type' => 'book', 'numberposts' => -1 ) );

foreach( $books as $book ){
	wp_delete_post( $book->ID, true );
}
*/

// Access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type='book'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );

$options = array(
	'cpt_manager' => 'Activate CPT Manager',
	'taxonomy_manager' => 'Activate Taxonomy Manager',
	'media_widget' => 'Activate Media Widget',
	'gallery_manager' => 'Activate Gallery Manager',
	'testimonial_manager' => 'Activate Testimonial Manager',
	'templates_manager' => 'Activate Templates Manager',
	'login_manager' => 'Activate Login Manager',
	'membership_manager' => 'Activate Membership Manager',
	'chat_manager' => 'Activate Chat Manager',

	'alecaddd_plugin' => '',
	'alecaddd_plugin_cpt' => '',
);

foreach( $options as $option => $value ){
	if( get_option( $option ) ){
		delete_option( $option );
	}
}
