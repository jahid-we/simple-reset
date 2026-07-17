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

// MAIN HANDLE RESET FUNCTION
	public function handle_reset() {

// DELETE ALL POSTS, PAGES, MEDIA
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

// DELETE ALL CATEGORIES & TAGS
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

// DELETE ALL COMMENTS
		if ( isset( $_POST['sr_delete_comments'] ) ) {

			$this->verify_request(
				'sr_delete_comments',
				'sr_delete_comments_nonce'
			);

			$this->delete_comments();

		}

// DELETE ALL USERS
		if ( isset( $_POST['sr_delete_users'] ) ) {

			$this->verify_request(
				'sr_delete_users',
				'sr_delete_users_nonce'
			);

			$this->delete_users();

		}

// DELETE ALL MENUS
		if ( isset( $_POST['sr_delete_menus'] ) ) {

			$this->verify_request(
				'sr_delete_menus',
				'sr_delete_menus_nonce'
			);

			$this->delete_menus();

		}

	}

// NONCE VERIFICATION
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

// DELETE ALL POSTS, PAGES, MEDIA
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

// DELETE ALL CATEGORIES & TAGS
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

// DELETE ALL COMMENTS
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

// DELETE ALL USERS
	private function delete_users() {

    $users = get_users();
	$current_user = get_current_user_id();

    foreach ( $users as $user ) {
		if ( $user->ID === $current_user ) {
            continue;
        }

        if ( in_array( 'administrator', $user->roles, true ) ) {
            continue;
        }

        wp_delete_user( $user->ID, $current_user );
    }

    $this->redirect();

	}

// DELETE ALL MENU
private function delete_menus() {

    $menus = wp_get_nav_menus();

    foreach ( $menus as $menu ) {

        wp_delete_nav_menu( $menu->term_id );

    }

    $this->redirect();

}

	private function redirect() {

		wp_safe_redirect(
			admin_url( 'admin.php?page=sr-reset-tools&deleted=1' )
		);

		exit;

	}

}