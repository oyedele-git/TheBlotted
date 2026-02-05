<?php
/**
 * Registers custom taxonomies used across the theme.
 *
 * @package theblotted
 */

function theblotted_register_custom_taxonomies() {
    $taxonomies = [
        'issue' => [
            'singular' => __( 'Issue', 'theblotted' ),
            'plural'   => __( 'Issues', 'theblotted' ),
            'slug'     => 'issue',
        ],
        'literature' => [
            'singular' => __( 'Literature Category', 'theblotted' ),
            'plural'   => __( 'Literature Categories', 'theblotted' ),
            'slug'     => 'literature-category',
        ],
        'pop_of_culture' => [
            'singular' => __( 'Pop of Culture Category', 'theblotted' ),
            'plural'   => __( 'Pop of Culture Categories', 'theblotted' ),
            'slug'     => 'pop-of-culture-category',
        ],
        'lifestyle' => [
            'singular' => __( 'Lifestyle Category', 'theblotted' ),
            'plural'   => __( 'Lifestyle Categories', 'theblotted' ),
            'slug'     => 'lifestyle-category',
        ],
        'comedy' => [
            'singular' => __( 'Comedy Category', 'theblotted' ),
            'plural'   => __( 'Comedy Categories', 'theblotted' ),
            'slug'     => 'comedy-category',
        ],
        'cartoons_crosswords' => [
            'singular' => __( 'Cartoons & Crosswords Category', 'theblotted' ),
            'plural'   => __( 'Cartoons & Crosswords Categories', 'theblotted' ),
            'slug'     => 'cartoons-crosswords-category',
        ],
    ];

    foreach ( $taxonomies as $taxonomy => $data ) {
        $labels = [
            'name'                       => $data['plural'],
            'singular_name'              => $data['singular'],
            'menu_name'                  => $data['plural'],
            'all_items'                  => sprintf( __( 'All %s', 'theblotted' ), $data['plural'] ),
            'edit_item'                  => sprintf( __( 'Edit %s', 'theblotted' ), $data['singular'] ),
            'view_item'                  => sprintf( __( 'View %s', 'theblotted' ), $data['singular'] ),
            'update_item'                => sprintf( __( 'Update %s', 'theblotted' ), $data['singular'] ),
            'add_new_item'               => sprintf( __( 'Add New %s', 'theblotted' ), $data['singular'] ),
            'new_item_name'              => sprintf( __( 'New %s Name', 'theblotted' ), $data['singular'] ),
            'parent_item'                => __( 'Parent Item', 'theblotted' ),
            'parent_item_colon'          => __( 'Parent Item:', 'theblotted' ),
            'search_items'               => sprintf( __( 'Search %s', 'theblotted' ), $data['plural'] ),
            'popular_items'              => __( 'Popular Items', 'theblotted' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'theblotted' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'theblotted' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'theblotted' ),
            'not_found'                  => __( 'No items found.', 'theblotted' ),
        ];

        $args = [
            'labels'            => $labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => [ 'slug' => $data['slug'] ],
        ];

        register_taxonomy( $taxonomy, [ 'post' ], $args );
    }
}
add_action( 'init', 'theblotted_register_custom_taxonomies' );
