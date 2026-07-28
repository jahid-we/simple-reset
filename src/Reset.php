<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Reset {

	/**
	 * Get registered custom post types that are safe to offer for deletion.
	 *
	 * @return array<string, \WP_Post_Type>
	 */
	public static function get_custom_post_types() {
		$core_post_types = [
			'post',
			'page',
			'attachment',
			'revision',
			'nav_menu_item',
			'custom_css',
			'customize_changeset',
			'oembed_cache',
			'user_request',
			'wp_block',
			'wp_template',
			'wp_template_part',
			'wp_global_styles',
			'wp_navigation',
			'wp_font_family',
			'wp_font_face',
		];

		$custom_post_types = get_post_types( [ '_builtin' => false ], 'objects' );

		foreach ( $core_post_types as $post_type ) {
			unset( $custom_post_types[ $post_type ] );
		}

		return $custom_post_types;
	}

	public function __construct() {
		add_action(
			'admin_init',
			[ $this, 'handle_reset' ]
		);
	}

	// MAIN HANDLE RESET FUNCTION
	public function handle_reset() {
		// Only run reset if form is submitted and relevant keys exist
		$is_reset_request = false;
		$all_actions = [
			'sr_delete_posts',
			'sr_delete_pages',
			'sr_delete_media',
			'sr_delete_revisions',
			'sr_delete_categories',
			'sr_delete_tags',
			'sr_delete_comments',
			'sr_delete_users',
			'sr_delete_menus',
			'sr_delete_post_auto-draft',
			'sr_delete_page_auto-draft',
			'sr_delete_trashed',
			'sr_reset_theme_customizer',
			'sr_delete_wc_products',
			'sr_delete_wc_coupons',
			'sr_delete_wc_product_categories',
			'sr_delete_wc_product_tags',
			'sr_delete_wc_product_attribute',
			'sr_delete_wc_orders',
		];

		$custom_post_types = self::get_custom_post_types();
		$custom_actions    = [];

		foreach ( $custom_post_types as $post_type => $post_type_object ) {
			$custom_actions[ 'sr_delete_cpt_' . $post_type ] = $post_type;
		}

		foreach ( array_merge( $all_actions, array_keys( $custom_actions ) ) as $action_key ) {
			if ( isset( $_POST[ $action_key ] ) ) {
				$is_reset_request = true;
				break;
			}
		}

		if ( ! $is_reset_request ) {
			return;
		}

		// Security feature check 1: Global Toggle
		if ( get_option( 'sr_enable_reset', '1' ) !== '1' ) {
			wp_die( esc_html__( 'Reset operations are globally disabled in settings.', 'simple-reset' ) );
		}

		// Security feature check 2: Allowed User IDs Restriction
		$allowed_ids_str = get_option( 'sr_allowed_user_ids', '' );
		if ( ! empty( $allowed_ids_str ) ) {
			$allowed_ids = array_map( 'intval', array_filter( array_map( 'trim', explode( ',', $allowed_ids_str ) ) ) );
			$current_user_id = get_current_user_id();
			if ( ! in_array( $current_user_id, $allowed_ids, true ) ) {
				wp_die( esc_html__( 'Your User ID is not authorized to run reset operations.', 'simple-reset' ) );
			}
		}

		// DELETE ALL POSTS, PAGES, MEDIA, REVISIONS, TRASHED
		$post_types = [
			'sr_delete_posts'     => 'post',
			'sr_delete_pages'     => 'page',
			'sr_delete_media'     => 'attachment',
			'sr_delete_revisions' => 'revision',
		];

		foreach ( $post_types as $action => $post_type ) {
			if ( isset( $_POST[ $action ] ) ) {
				$this->verify_request( $action, $action . '_nonce' );
				$this->delete_post_type( $post_type, 'any', $action );
			}
		}

		// DELETE ALL CATEGORIES & TAGS
		$taxonomies = [
			'sr_delete_categories' => 'category',
			'sr_delete_tags'       => 'post_tag',
		];

		foreach ( $taxonomies as $action => $taxonomy ) {
			if ( isset( $_POST[ $action ] ) ) {
				$this->verify_request( $action, $action . '_nonce' );
				$this->delete_terms( $taxonomy, $action );
			}
		}

		// DELETE ALL COMMENTS
		if ( isset( $_POST['sr_delete_comments'] ) ) {
			$this->verify_request( 'sr_delete_comments', 'sr_delete_comments_nonce' );
			$this->delete_comments( 'sr_delete_comments' );
		}

		// DELETE ALL USERS
		if ( isset( $_POST['sr_delete_users'] ) ) {
			$this->verify_request( 'sr_delete_users', 'sr_delete_users_nonce' );
			$this->delete_users( 'sr_delete_users' );
		}

		// DELETE ALL MENUS
		if ( isset( $_POST['sr_delete_menus'] ) ) {
			$this->verify_request( 'sr_delete_menus', 'sr_delete_menus_nonce' );
			$this->delete_menus( 'sr_delete_menus' );
		}

		// AUTO DRAFTS POSTS & PAGES
		if ( isset( $_POST['sr_delete_post_auto-draft'] ) ) {
			$this->verify_request( 'sr_delete_post_auto-draft', 'sr_delete_post_auto-draft_nonce' );
			$this->delete_post_type( 'post', 'auto-draft', 'sr_delete_post_auto-draft' );
		}

		if ( isset( $_POST['sr_delete_page_auto-draft'] ) ) {
			$this->verify_request( 'sr_delete_page_auto-draft', 'sr_delete_page_auto-draft_nonce' );
			$this->delete_post_type( 'page', 'auto-draft', 'sr_delete_page_auto-draft' );
		}

		// DELETE TRASH
		if ( isset( $_POST['sr_delete_trashed'] ) ) {
			$this->verify_request( 'sr_delete_trashed', 'sr_delete_trashed_nonce' );
			$this->delete_trash( 'sr_delete_trashed' );
		}

		// RESET ACTIVE THEME CUSTOMIZER SETTINGS.
		if ( isset( $_POST['sr_reset_theme_customizer'] ) ) {
			$this->verify_request( 'sr_reset_theme_customizer', 'sr_reset_theme_customizer_nonce' );
			$this->reset_theme_customizer( 'sr_reset_theme_customizer' );
		}

		foreach ( $custom_actions as $action => $post_type ) {
			if ( isset( $_POST[ $action ] ) ) {
				$this->verify_request( $action, $action . '_nonce' );
				$this->delete_post_type( $post_type, 'any', $action, 'sr-custom-post-types' );
			}
		}

		// DELETE ALL WOOCOMMERCE PRODUCTS
		if ( isset( $_POST['sr_delete_wc_products'] ) ) {

    		$this->verify_request(
        		'sr_delete_wc_products',
        		'sr_delete_wc_products_nonce'
    		);

    		$this->delete_wc_post_type(
        		'product',
        		'sr_delete_wc_products',
        		'products'
    		);
		}
		// DELETE ALL WOOCOMMERCE COUPONS
		if ( isset( $_POST['sr_delete_wc_coupons'] ) ) {
			
    		$this->verify_request(
        		'sr_delete_wc_coupons',
        		'sr_delete_wc_coupons_nonce'
    		);

    		$this->delete_wc_post_type(
        		'shop_coupon',
        		'sr_delete_wc_coupons',
        		'coupons'
    		);
		}

		// DELETE WOOCOMMERCE TAXONOMIES
		$wc_taxonomies = [
    		'sr_delete_wc_product_categories' => [
				'taxonomy' => 'product_cat',
				'label'    => 'product categories',
    		],
    		'sr_delete_wc_product_tags' => [
				'taxonomy' => 'product_tag',
        		'label'    => 'product tags',
    		],
		];

		foreach ( $wc_taxonomies as $action => $data ) {

    		if ( ! isset( $_POST[ $action ] ) ) {
        		continue;
    }

    	$this->verify_request(
        $action,
        $action . '_nonce'
    );

    	$this->delete_wc_taxonomy(
        $data['taxonomy'],
        $action,
        $data['label']
    );
	}

	// DELETE WOOCOMMERCE PRODUCT ATTRIBUTES
	if ( isset( $_POST['sr_delete_wc_product_attributes'] ) ) {

    		$this->verify_request(
        		'sr_delete_wc_product_attributes',
        		'sr_delete_wc_product_attributes_nonce'
    		);

    		$this->delete_wc_attributes(
        		'product_attribute',
        		'sr_delete_wc_product_attribute',
        		'product attributes'
    		);
		}
	// DELETE WOOCOMMERCE ORDERS
	if ( isset( $_POST['sr_delete_wc_orders'] ) ) {

    		$this->verify_request(
        		'sr_delete_wc_orders',
        		'sr_delete_wc_orders_nonce'
    		);

    		$this->delete_wc_orders();
		}

	}

	// NONCE & PERMISSION VERIFICATION
	private function verify_request( $action, $nonce_name ) {
		if ( ! isset( $_POST[ $nonce_name ] ) ) {
			wp_die( esc_html__( 'Nonce is missing.', 'simple-reset' ) );
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST[ $nonce_name ] ) );

		if ( ! wp_verify_nonce( $nonce, $action ) ) {
			wp_die( esc_html__( 'Security check failed.', 'simple-reset' ) );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission.', 'simple-reset' ) );
		}

		if (
			'1' === get_option( 'sr_require_backup', '0' ) &&
			( ! isset( $_POST['sr_backup_confirmed'] ) || '1' !== $_POST['sr_backup_confirmed'] )
		) {
			wp_die( esc_html__( 'Please confirm that you have backed up the database before continuing.', 'simple-reset' ) );
		}
	}

	// DELETE ALL POSTS, PAGES, MEDIA, REVISIONS
	private function delete_post_type( string $post_type, string $post_status = 'any', string $action_name = '', string $redirect_page = 'sr-reset-tools' ) {
		if ( 'any' === $post_status ) {
			$post_status = array_keys( get_post_stati() );
		}

		$protected_post_ids = $this->get_protected_post_ids( $post_type );

		$posts = get_posts(
			[
				'post_type'      => $post_type,
				'post_status'    => $post_status,
				'posts_per_page' => -1,
			]
		);

		foreach ( $posts as $post ) {
			if ( in_array( $post->ID, $protected_post_ids, true ) ) {
				continue;
			}

			if ( 'attachment' === $post_type ) {
				wp_delete_attachment( $post->ID, true );
			} else {
				wp_delete_post( $post->ID, true );
			}
		}

		Log::add(
			$action_name,
			sprintf( 'Deleted %d %s .', count( $posts ), $post_type )
		);

		$this->redirect( $action_name, $redirect_page );
	}

	/**
	 * Get post IDs that must not be removed because another plugin relies on them.
	 *
	 * @param string $post_type The post type being deleted.
	 * @return int[] Protected post IDs.
	 */
	private function get_protected_post_ids( string $post_type ) {
		$protected_post_ids = [];

		// Elementor stores its active Site Settings kit as an elementor_library post.
		if ( 'elementor_library' === $post_type ) {
			$active_kit_id = (int) get_option( 'elementor_active_kit', 0 );

			if ( $active_kit_id > 0 && get_post( $active_kit_id ) ) {
				$protected_post_ids[] = $active_kit_id;
			}
		}

		return $protected_post_ids;
	}

	// DELETE ALL CATEGORIES & TAGS
	private function delete_terms( $taxonomy, string $action_name = '' ) {
		$terms = get_terms(
			[
				'taxonomy'   => $taxonomy,
				'hide_empty' => false,
			]
		);

		$default_category = (int) get_option( 'default_category' );

		foreach ( $terms as $term ) {
			if ( 'category' === $taxonomy && $term->term_id === $default_category ) {
				continue;
			}
			wp_delete_term( $term->term_id, $taxonomy );
		}

		Log::add(
			$action_name,
			sprintf( 'Deleted %d %s.', count( $terms ), $taxonomy )
		);

		$this->redirect( $action_name );
	}

	// DELETE ALL COMMENTS
	private function delete_comments( string $action_name = '' ) {
		$comments = get_comments(
			[
				'status' => 'all',
			]
		);

		foreach ( $comments as $comment ) {
			wp_delete_comment( $comment->comment_ID, true );
		}

		Log::add(
			$action_name,
			sprintf( 'Deleted %d comments.', count( $comments ) )
		);

		$this->redirect( $action_name );
	}

	// DELETE ALL USERS
	private function delete_users( string $action_name = '' ) {
		$users        = get_users();
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

		Log::add(
			$action_name,
			sprintf( 'Deleted %d users.', count( $users ) )
		);

		$this->redirect( $action_name );
	}

	// DELETE ALL MENU
	private function delete_menus( string $action_name = '' ) {
		$menus = wp_get_nav_menus();

		foreach ( $menus as $menu ) {
			wp_delete_nav_menu( $menu->term_id );
		}

		Log::add(
			$action_name,
			sprintf( 'Deleted %d menus.', count( $menus ) )
		);

		$this->redirect( $action_name );
	}

	// DELETE TRASH
	private function delete_trash( string $action_name = '' ) {
		$post_types = get_post_types( [ 'show_ui' => true ] );

		foreach ( $post_types as $post_type ) {
			$posts = get_posts(
				[
					'post_type'      => $post_type,
					'post_status'    => 'trash',
					'posts_per_page' => -1,
				]
			);

			foreach ( $posts as $post ) {
				wp_delete_post( $post->ID, true );
			}
		}

		Log::add(
			$action_name,
			sprintf( 'Deleted %d trashed items.', count( $posts ) )
		);

		$this->redirect( $action_name );
	}

	// RESET ACTIVE THEME CUSTOMIZER SETTINGS.
	private function reset_theme_customizer( string $action_name = '' ) {
		remove_theme_mods();

		Log::add(
			$action_name,
			'Reset active theme customizer settings.'
		);

		$this->redirect( $action_name );
	}

	// RESET ALL WOOCOMMERCE PRODUCTS
	private function delete_wc_post_type(
		string $post_type,
		string $action_name,
		string $label
	) {

	if ( ! class_exists( 'WooCommerce' ) ) {
		wp_die( 'WooCommerce is not active.' );
	}

	$posts = get_posts(
		[
			'post_type'      => $post_type,
			'post_status'    => 'any',
			'posts_per_page' => -1,
		]
	);
	$count = 0;
	foreach ( $posts as $post ) {
		wp_delete_post( $post->ID, true );
		$count++;
	}

	Log::add(
		$action_name,
		sprintf( 'Deleted %d WooCommerce %s.', $count, $label )
	);

	$this->redirect( $action_name, 'sr-reset-tools' );
}

// RESET ALL WOOCOMMERCE Taxonomy
private function delete_wc_taxonomy(
    string $taxonomy,
    string $action_name,
    string $label
) {

    if ( ! class_exists( 'WooCommerce' ) ) {
        wp_die( 'WooCommerce is not active.' );
    }

    $terms = get_terms(
        [
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
            'number'     => 999999,
        ]
    );

    foreach ( $terms as $term ) {
        wp_delete_term( $term->term_id, $taxonomy );
    }

    Log::add(
        $action_name,
        sprintf( 'Deleted %d WooCommerce %s.', count( $terms ), $label )
    );

    $this->redirect( $action_name, 'sr-reset-tools' );
}

private function delete_wc_attributes() {

    if ( ! class_exists( 'WooCommerce' ) ) {
        wp_die( 'WooCommerce is not active.' );
    }

    $attributes = wc_get_attribute_taxonomies();

    $deleted_attributes = 0;
    $deleted_terms      = 0;

    foreach ( $attributes as $attribute ) {

        // pa_color
        // pa_size
        $taxonomy = wc_attribute_taxonomy_name(
            $attribute->attribute_name
        );

        $terms = get_terms(
            [
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
            ]
        );

        if ( is_wp_error( $terms ) ) {
            continue;
        }

        foreach ( $terms as $term ) {

            if ( wp_delete_term( $term->term_id, $taxonomy ) ) {
                $deleted_terms++;
            }

        }

        if ( wc_delete_attribute( $attribute->attribute_id ) ) {
            $deleted_attributes++;
        }

    }

    Log::add(
        'sr_delete_wc_product_attributes',
        sprintf(
            'Deleted %d attributes and %d attribute terms.',
            $deleted_attributes,
            $deleted_terms
        )
    );

    $this->redirect(
        'sr_delete_wc_product_attributes',
        'sr-reset-tools'
    );
}

// Delete WooCommerce Orders
private function delete_wc_orders() {

    if ( ! class_exists( 'WooCommerce' ) ) {
        wp_die( 'WooCommerce is not active.' );
    }

    $orders = wc_get_orders(
        [
            'limit'  => -1,
            'return' => 'ids',
        ]
    );

    $count = 0;

    foreach ( $orders as $order_id ) {

        $order = wc_get_order( $order_id );

        if ( $order ) {
            $order->delete( true );
            $count++;
        }

    }

    Log::add(
        'sr_delete_wc_orders',
        sprintf( 'Deleted %d WooCommerce orders.', $count )
    );

    $this->redirect( 'sr_delete_wc_orders', 'sr-reset-tools' );
}

	private function redirect( string $action_name = '', string $redirect_page = 'sr-reset-tools' ) {
		// Send Email Alert if enabled
		if ( get_option( 'sr_email_alert', '0' ) === '1' ) {
			$current_user = wp_get_current_user();
			$to           = get_option( 'admin_email' );
			$subject      = sprintf( '[Simple Reset] Alert: Cleanup Action Executed on %s', get_bloginfo( 'name' ) );

			$action_labels = [
				'sr_delete_posts'           => 'All Posts',
				'sr_delete_pages'           => 'All Pages',
				'sr_delete_media'           => 'All Media',
				'sr_delete_revisions'       => 'All Revisions',
				'sr_delete_categories'      => 'All Categories',
				'sr_delete_tags'            => 'All Tags',
				'sr_delete_comments'        => 'All Comments',
				'sr_delete_users'           => 'All Users',
				'sr_delete_menus'           => 'All Menus',
				'sr_delete_post_auto-draft' => 'Post Auto Drafts',
				'sr_delete_page_auto-draft' => 'Page Auto Drafts',
				'sr_delete_trashed'         => 'Trashed Items',
				'sr_reset_theme_customizer' => 'Theme Customizer',
				'sr_delete_wc_products'     => 'All WooCommerce Products',
				'sr_delete_wc_coupons'      => 'All WooCommerce Coupons',
				'sr_delete_wc_product_categories' => 'All WooCommerce Product Categories',
				'sr_delete_wc_product_tags' => 'All WooCommerce Product Tags',
				'sr_delete_wc_product_attribute' => 'All WooCommerce Product Attributes',
				'sr_delete_wc_orders'     => 'All WooCommerce Orders',
				
			];

			$human_action = isset( $action_labels[ $action_name ] ) ? $action_labels[ $action_name ] : $action_name;

			$message = sprintf(
				"Security Alert: A database cleanup action has been executed.\n\n" .
				"Site: %s (%s)\n" .
				"Executed Action: %s\n" .
				"Performed By: %s (%s)\n" .
				"Timestamp: %s\n\n" .
				"This email is sent automatically by the Simple Reset plugin security notifications.",
				get_bloginfo( 'name' ),
				home_url(),
				$human_action,
				$current_user->display_name,
				$current_user->user_email,
				current_time( 'mysql' )
			);

			wp_mail( $to, $subject, $message );
		}

		wp_safe_redirect(
			admin_url( 'admin.php?page=' . $redirect_page . '&deleted=1' )
		);
		exit;
	}

}
