<?php

/**
 *  @package AlecadddPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;

class TestimonialController extends BaseController
{

	public function register()
	{
		if( ! $this->activated( 'testimonial_manager' ) ){
			return;
		}

		add_action( 'init', array( $this, 'testimonial_cpt' ) );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		add_action( 'save_post', array( $this, 'save_meta_box' ) );
	}

	public function add_meta_boxes()
	{
		add_meta_box(
			'testimonial_author', // $id
			'Author', // $author
			array( $this, 'render_author_box' ), // $callback
			'testimonial', // $screen = post type ID = testimonial, post, page
			'side', // $context = normal, side, advanced
			'default' // $priority = high, low, default
		);
	}

	public function render_author_box( $post )
	{
		wp_nonce_field( 'alecaddd_testimonial', 'alecaddd_testimonial_nonce' );

		$data = get_post_meta( $post->ID, '_alecaddd_testimonial_key', true );
		$name = isset( $data['name'] ) ? $data['name'] : '';
		$email = isset( $data['email'] ) ? $data['email'] : '';
		$approved = isset( $data['approved'] ) && $data['approved'] ? true : false;
		$featured = isset( $data['featured'] ) && $data['featured'] ? true : false;

	?>
		<p>
			<label class="meta-label" for="alecaddd_testimonial_author">Testimonial Author</label>
			<input type="text" name="alecaddd_testimonial_author" name="alecaddd_testimonial_author" class="widefat" value="<?php echo esc_attr( $name ) ?>" />
		</p>

		<p>
			<label class="meta-label" for="alecaddd_testimonial_email">Author Email</label>
			<input type="email" id="alecaddd_testimonial_email" name="alecaddd_testimonial_email" class="widefat" value="<?php echo esc_attr( $email ); ?>">
		</p>

		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="alecaddd_testimonial_approved">Approved</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="alecaddd_testimonial_approved" name="alecaddd_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="alecaddd_testimonial_approved"><div></div></label>
				</div>
			</div>
		</div>

		<div class="meta-container">
			<label class="meta-label w-50 text-left" for="alecaddd_testimonial_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="alecaddd_testimonial_featured" name="alecaddd_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="alecaddd_testimonial_featured"><div></div></label>
				</div>
			</div>
		</div>

	<?php
	}

	public function save_meta_box( $post_id )
	{
		if( ! isset( $_POST['alecaddd_testimonial_nonce'] ) ){
			return $post_id;
		}

		$nonce = $_POST['alecaddd_testimonial_nonce'];

		if( ! wp_verify_nonce( $nonce, 'alecaddd_testimonial' ) ){
			return $post_id;
		}

		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
			return $post_id;
		}

		if( ! current_user_can( 'edit_post', $post_id ) ){
			return $post_id;
		}

		$data = array(
			'name' => sanitize_text_field( $_POST['alecaddd_testimonial_author'] ),
			'email' => sanitize_text_field( $_POST['alecaddd_testimonial_email'] ),
			'approved' => isset( $_POST['alecaddd_testimonial_approved'] ) ? 1 : 0,
			'featured' => isset( $_POST['alecaddd_testimonial_featured'] ) ? 1 : 0,
		);

		update_post_meta( $post_id, '_alecaddd_testimonial_key', $data );
	}

	public function testimonial_cpt()
	{
		$labels = array(
			'name' => 'Testimonials',
			'singular_name' => 'Testimonial',
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-testimonial',
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' => array( 'title', 'editor' ),

		);

		register_post_type( 'testimonial', $args );
	}

}
