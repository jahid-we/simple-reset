<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Statistics {


// Counters

public function get_post_type_count( $post_type ) {

    return count(
        get_posts(
            [
                'post_type'      => $post_type,
                'posts_per_page' => -1,
                'post_status'    => 'any',
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

}