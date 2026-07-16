<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Reset {

	public function __construct() {

		add_action(
			'admin_init',
			[ $this, 'handle_reset' ]
		);

	}

	public function handle_reset() {

		$post_types = [
			'sr_delete_posts' => 'post',
			'sr_delete_pages' => 'page',
			'sr_delete_media' => 'attachment',
		];

		foreach ( $post_types as $action => $post_type ) {

			if ( ! isset( $_POST[ $action ] ) ) {
				continue;
			}

			$this->verify_request(
				$action,
				$action . '_nonce'
			);

			$this->delete_post_type( $post_type );

		}

		$taxonomies = [
			'sr_delete_categories' => 'category',
			'sr_delete_tags'       => 'post_tag',
		];

		foreach ( $taxonomies as $action => $taxonomy ) {

			if ( ! isset( $_POST[ $action ] ) ) {
				continue;
			}

			$this->verify_request(
				$action,
				$action . '_nonce'
			);

			$this->delete_terms( $taxonomy );

		}

		if ( isset( $_POST['sr_delete_comments'] ) ) {

			$this->verify_request(
				'sr_delete_comments',
				'sr_delete_comments_nonce'
			);

			$this->delete_comments();

		}

	}

	private function verify_request( $action, $nonce_name ) {

		if ( ! isset( $_POST[ $nonce_name ] ) ) {
			wp_die( esc_html__( 'Nonce is missing.', 'simple-reset' ) );
		}

		$nonce = sanitize_text_field(
			wp_unslash( $_POST[ $nonce_name ] )
		);

		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			wp_die( esc_html__( 'Security check failed.', 'simple-reset' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission.', 'simple-reset' ) );
		}

	}

	private function delete_post_type( $post_type ) {

		$posts = get_posts(
			[
				'post_type'      => $post_type,
				'post_status'    => 'any',
				'posts_per_page' => -1,
			]
		);

		foreach ( $posts as $post ) {

			if ( 'attachment' === $post_type ) {
				wp_delete_attachment( $post->ID, true );
			} else {
				wp_delete_post( $post->ID, true );
			}

		}

		$this->redirect();

	}

	private function delete_terms( $taxonomy ) {

		$terms = get_terms(
			[
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			]
		);

		$default_category = (int) get_option( 'default_category' );

		foreach ( $terms as $term ) {

			if (
				'category' === $taxonomy &&
				$term->term_id === $default_category
			) {
				continue;
			}

			wp_delete_term(
				$term->term_id,
				$taxonomy
			);

		}

		$this->redirect();

	}

	private function delete_comments() {

		$comments = get_comments(
			[
				'status' => 'all',
			]
		);

		foreach ( $comments as $comment ) {
			wp_delete_comment( $comment->comment_ID, true );
		}

		$this->redirect();

	}

	private function redirect() {

		wp_safe_redirect(
			admin_url( 'admin.php?page=sr-reset-tools&deleted=1' )
		);

		exit;

	}


// Counters

public function get_post_type_count( $post_type ) {

    $count = wp_count_posts( $post_type );

    return array_sum( (array) $count );

}

public function get_comment_count() {

    $count = wp_count_comments();

    return $count->total_comments;

}
public function get_taxonomy_count( $taxonomy ) {

    return wp_count_terms(
        [
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ]
    );

}

}