<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Statistics {


// Counters

public function get_post_type_count( string $post_type,string $post_status = 'any') {

    return count(
        get_posts(
            [
                'post_type'      => $post_type,
                'posts_per_page' => -1,
                'post_status'    => $post_status,
                'fields'         => 'ids',
            ]
        )
    );
}

public function get_comment_count() {

    $count = wp_count_comments();

    return $count->total_comments;

}
public function get_taxonomy_count( $taxonomy ) {

    return (int) wp_count_terms(
        [
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ]
    );

}
public function get_user_count() {

    return count( get_users() );

}

public function get_menu_count() {

    $menus = get_terms( [
        'taxonomy'   => 'nav_menu',
        'hide_empty' => false,
    ] );

    return count( $menus );

}

public function get_trash_count() {

    $total = 0;

    $post_types = get_post_types(
        [
            'show_ui' => true,
        ]
    );

    foreach ( $post_types as $post_type ) {

        $count = wp_count_posts( $post_type );

        if ( isset( $count->trash ) ) {
            $total += (int) $count->trash;
        }

    }

    return $total;

}

}