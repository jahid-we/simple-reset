<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Statistics {


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

    return (int) wp_count_terms(
        [
            'taxonomy'   => $taxonomy,
            'hide_empty' => false,
        ]
    );

}

}