<?php

/**
 * ACF Field Group Registrations
 *
 * Registers all Advanced Custom Fields field groups for The Blotted theme.
 * Requires ACF plugin to be active.
 *
 * @package theblotted
 */

if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

// ---------------------------------------------------------------------------
// Helper: find the Ad Settings page ID by its template (cached per request)
// ---------------------------------------------------------------------------

/**
 * Returns the ID of the page using the Theme Ad Settings template, or false
 * if none exists yet. Result is cached in a static variable.
 *
 * @return int|false
 */
function theblotted_get_settings_page_id() {
    static $id = null;
    if ( $id !== null ) {
        return $id;
    }
    $pages = get_posts(
        [
            'post_type'      => 'page',
            'meta_key'       => '_wp_page_template',
            'meta_value'     => 'page-theblotted-settings.php',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'no_found_rows'  => true,
        ]
    );
    $id = ! empty( $pages ) ? $pages[0] : false;
    return $id;
}

// ---------------------------------------------------------------------------
// Group 1: Global Ad Settings (Theme Ad Settings page — ACF Free compatible)
// ---------------------------------------------------------------------------

acf_add_local_field_group(
    [
        'key'    => 'group_theblotted_global_ads',
        'title'  => 'Global Ad Settings',
        'fields' => [
            [
                'key'           => 'field_global_sidebar_ad',
                'label'         => 'Sidebar Ad Image',
                'name'          => 'global_sidebar_ad',
                'type'          => 'image',
                'instructions'  => 'Ad shown in the card-grid slot across all category pages and the single post sidebar. Recommended size: 300×250px.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'allow_null'    => 1,
            ],
            [
                'key'           => 'field_global_banner_ad',
                'label'         => 'Banner Ad Image',
                'name'          => 'global_banner_ad',
                'type'          => 'image',
                'instructions'  => 'Full-width banner ad at the bottom of category pages. Recommended size: 1200×250px.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'allow_null'    => 1,
            ],
            [
                'key'           => 'field_home_mid_banner_ad',
                'label'         => 'Homepage Mid-Page Banner Ad',
                'name'          => 'home_mid_banner_ad',
                'type'          => 'image',
                'instructions'  => 'Large banner displayed between the Popular and category sections on the homepage.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'allow_null'    => 1,
            ],
            [
                'key'           => 'field_home_issues_section_ad',
                'label'         => 'Homepage Issues Section Ad',
                'name'          => 'home_issues_section_ad',
                'type'          => 'image',
                'instructions'  => 'Square ad inserted within the Issues card grid on the homepage. Recommended size: 300×300px.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'allow_null'    => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-theblotted-settings.php',
                ],
            ],
        ],
    ]
);

// ---------------------------------------------------------------------------
// Group 2: Single Post Article Settings
// ---------------------------------------------------------------------------

acf_add_local_field_group(
    [
        'key'                   => 'group_theblotted_post_fields',
        'title'                 => 'Article Settings',
        'fields'                => [
            [
                'key'          => 'field_article_subtitle',
                'label'        => 'Subtitle',
                'name'         => 'article_subtitle',
                'type'         => 'text',
                'instructions' => 'Optional subheading displayed beneath the article title in the hero section.',
                'placeholder'  => 'e.g. A deep dive into modern writing culture',
                'allow_null'   => 1,
            ],
            [
                'key'           => 'field_article_type',
                'label'         => 'Article Type',
                'name'          => 'article_type',
                'type'          => 'select',
                'instructions'  => 'Overrides the category label shown above the title. Leave blank to use the post\'s category name.',
                'choices'       => [
                    ''          => '— Use Category —',
                    'Opinion'   => 'Opinion',
                    'Feature'   => 'Feature',
                    'Review'    => 'Review',
                    'Report'    => 'Report',
                    'Interview' => 'Interview',
                ],
                'default_value' => '',
                'allow_null'    => 1,
                'ui'            => 1,
            ],
            [
                'key'           => 'field_mid_article_image',
                'label'         => 'Mid-Article Pull Image',
                'name'          => 'mid_article_image',
                'type'          => 'image',
                'instructions'  => 'Optional image displayed in a split layout after the article body (mirrors the .history-002 section in the design). Leave blank to hide this section.',
                'return_format' => 'array',
                'preview_size'  => 'medium',
                'allow_null'    => 1,
            ],
        ],
        'location'              => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'post',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
    ]
);

// ---------------------------------------------------------------------------
// Group 3: Category Page — Featured Posts (Lifestyle, Comedy, Issues, Pop of Culture, Literature)
// ---------------------------------------------------------------------------

acf_add_local_field_group(
    [
        'key'    => 'group_theblotted_page_featured',
        'title'  => 'Featured Posts',
        'fields' => [
            [
                'key'           => 'field_featured_posts',
                'label'         => 'Featured Posts',
                'name'          => 'featured_posts',
                'type'          => 'relationship',
                'instructions'  => 'Manually select up to 5 posts to pin at the top of this category page. If left empty, the 5 most recent posts are shown automatically.',
                'post_type'     => [ 'post' ],
                'filters'       => [ 'search', 'taxonomy' ],
                'max'           => 5,
                'return_format' => 'object',
                'ui'            => 1,
                'allow_null'    => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-lifestyles.php',
                ],
            ],
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-comedy.php',
                ],
            ],
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-issues.php',
                ],
            ],
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-pop-of-culture.php',
                ],
            ],
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-literature.php',
                ],
            ],
        ],
    ]
);

// ---------------------------------------------------------------------------
// Group 4: Cartoons & Crosswords Page — Featured Posts (separate per section)
// ---------------------------------------------------------------------------

acf_add_local_field_group(
    [
        'key'    => 'group_theblotted_cc_featured',
        'title'  => 'Featured Cartoons & Crosswords',
        'fields' => [
            [
                'key'           => 'field_featured_cartoons',
                'label'         => 'Featured Cartoons',
                'name'          => 'featured_cartoons',
                'type'          => 'relationship',
                'instructions'  => 'Manually pin up to 5 cartoon posts at the top of the Cartoons section. Leave empty to auto-load by date.',
                'post_type'     => [ 'post' ],
                'filters'       => [ 'search', 'taxonomy' ],
                'max'           => 5,
                'return_format' => 'object',
                'allow_null'    => 1,
            ],
            [
                'key'           => 'field_featured_crosswords',
                'label'         => 'Featured Crosswords',
                'name'          => 'featured_crosswords',
                'type'          => 'relationship',
                'instructions'  => 'Manually pin up to 5 crossword posts at the top of the Crosswords section. Leave empty to auto-load by date.',
                'post_type'     => [ 'post' ],
                'filters'       => [ 'search', 'taxonomy' ],
                'max'           => 5,
                'return_format' => 'object',
                'allow_null'    => 1,
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-cartoons-crosswords.php',
                ],
            ],
        ],
    ]
);

// ---------------------------------------------------------------------------
// Helper: Get ACF image URL with fallback
// ---------------------------------------------------------------------------

/**
 * Returns the URL of an ACF image field, falling back to a static URL if
 * the field is empty or ACF is not active.
 *
 * @param string   $field_name  ACF field name.
 * @param int|bool $post_id     Post ID to read from, or false to use current post.
 * @param string   $fallback    URL to return when the field is empty.
 * @return string
 */
function theblotted_acf_img_url( $field_name, $post_id, $fallback ) {
    if ( ! function_exists( 'get_field' ) || ! $post_id ) {
        return $fallback;
    }
    $img = get_field( $field_name, $post_id );
    return ! empty( $img['url'] ) ? esc_url( $img['url'] ) : $fallback;
}
