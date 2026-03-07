<?php

/**
 * Template part for Issues Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theblotted
 */

$cat_slug  = 'issues';
$cat_label = 'Issues';

$cat_term = get_term_by( 'slug', $cat_slug, 'category' );
$cat_link = $cat_term ? get_term_link( $cat_term ) : home_url( '/' );

// Featured section: use ACF pinned posts if set, otherwise 5 most recent
$featured_posts = [];
if ( function_exists( 'get_field' ) ) {
    $acf_featured = get_field( 'featured_posts' );
    if ( ! empty( $acf_featured ) ) {
        $featured_posts = $acf_featured;
    }
}
if ( empty( $featured_posts ) ) {
    $featured_query = new WP_Query(
        [
        'category_name'       => $cat_slug,
        'posts_per_page'      => 5,
        'ignore_sticky_posts' => 1,
        'orderby'             => 'date',
        'order'               => 'DESC',
        ]
    );
    $featured_posts = $featured_query->posts;
    wp_reset_postdata();
}

$post1 = isset( $featured_posts[0] ) ? $featured_posts[0] : null;
$post2 = isset( $featured_posts[1] ) ? $featured_posts[1] : null;
$post3 = isset( $featured_posts[2] ) ? $featured_posts[2] : null;
$post4 = isset( $featured_posts[3] ) ? $featured_posts[3] : null;
$post5 = isset( $featured_posts[4] ) ? $featured_posts[4] : null;

$featured_ids = array_column( $featured_posts, 'ID' );

// Explore section: up to 11 more posts
$explore_query = new WP_Query(
    [
    'category_name'       => $cat_slug,
    'posts_per_page'      => 11,
    'post__not_in'        => $featured_ids,
    'ignore_sticky_posts' => 1,
    'orderby'             => 'date',
    'order'               => 'DESC',
    ]
);
$explore_posts = $explore_query->posts;
wp_reset_postdata();

$ads_img = theblotted_acf_img_url( 'global_sidebar_ad', theblotted_get_settings_page_id(), esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/Frame 46.png' ) );
$ads_bg  = theblotted_acf_img_url( 'global_banner_ad', theblotted_get_settings_page_id(), esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/Frame 455.png' ) );
?>

<main>
    <div class="app-wrapper">
        <section class="lifestyle-container">
            <div class="lifestyle-cards">
                <!-- First (featured) card -->
                <div class="first-card">
                    <?php if ( $post1 ) : ?>
                    <div class="card-container">
                        <div class="card-img">
                            <?php if ( has_post_thumbnail( $post1 ) ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $post1 ) ); ?>">
                                    <?php echo get_the_post_thumbnail( $post1, 'large', [ 'alt' => esc_attr( get_the_title( $post1 ) ) ] ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="text-container">
                            <h2 class="title">
                                <a href="<?php echo esc_url( get_permalink( $post1 ) ); ?>">
                                    <?php echo esc_html( get_the_title( $post1 ) ); ?>
                                </a>
                            </h2>
                            <p class="discription">
                                <?php
                                $exc = get_the_excerpt( $post1 );
                                if ( $exc === '' ) $exc = get_the_content( null, false, $post1 );
                                echo esc_html( wp_trim_words( wp_strip_all_tags( $exc ), 25, '…' ) );
                                ?>
                            </p>
                            <span class="author">
                                <?php echo esc_html( get_the_date( 'F j', $post1 ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $post1->post_author ) ); ?>
                            </span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <!-- Secondary cards -->
                <div class="second-card">
                    <div>
                        <?php foreach ( [ $post2, $post3 ] as $idx => $p ) : ?>
                            <?php if ( $p ) : ?>
                            <div class="card-container <?php echo $idx === 0 ? 'card-1' : 'card-2'; ?>">
                                <div class="card-img">
                                    <?php if ( has_post_thumbnail( $p ) ) : ?>
                                        <a href="<?php echo esc_url( get_permalink( $p ) ); ?>">
                                            <?php echo get_the_post_thumbnail( $p, 'medium', [ 'alt' => esc_attr( get_the_title( $p ) ) ] ); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="text-container">
                                    <h2 class="title">
                                        <a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a>
                                    </h2>
                                    <p class="discription">
                                        <?php
                                        $exc = get_the_excerpt( $p );
                                        if ( $exc === '' ) $exc = get_the_content( null, false, $p );
                                        echo esc_html( wp_trim_words( wp_strip_all_tags( $exc ), 18, '…' ) );
                                        ?>
                                    </p>
                                    <span class="author">
                                        <?php echo esc_html( get_the_date( 'F j', $p ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $p->post_author ) ); ?>
                                    </span>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div>
                        <?php if ( $post4 ) : ?>
                        <div class="card-container card-1">
                            <div class="card-img">
                                <?php if ( has_post_thumbnail( $post4 ) ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $post4 ) ); ?>">
                                        <?php echo get_the_post_thumbnail( $post4, 'medium', [ 'alt' => esc_attr( get_the_title( $post4 ) ) ] ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="text-container">
                                <h2 class="title">
                                    <a href="<?php echo esc_url( get_permalink( $post4 ) ); ?>"><?php echo esc_html( get_the_title( $post4 ) ); ?></a>
                                </h2>
                                <p class="discription">
                                    <?php
                                    $exc = get_the_excerpt( $post4 );
                                    if ( $exc === '' ) $exc = get_the_content( null, false, $post4 );
                                    echo esc_html( wp_trim_words( wp_strip_all_tags( $exc ), 18, '…' ) );
                                    ?>
                                </p>
                                <span class="author">
                                    <?php echo esc_html( get_the_date( 'F j', $post4 ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $post4->post_author ) ); ?>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="image card-2 show">
                            <img src="<?php echo $ads_img; ?>" alt="advertisement" />
                        </div>
                        <?php if ( $post5 ) : ?>
                        <div class="card-container card-2 hide">
                            <div class="card-img">
                                <?php if ( has_post_thumbnail( $post5 ) ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $post5 ) ); ?>">
                                        <?php echo get_the_post_thumbnail( $post5, 'medium', [ 'alt' => esc_attr( get_the_title( $post5 ) ) ] ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="text-container">
                                <h2 class="title">
                                    <a href="<?php echo esc_url( get_permalink( $post5 ) ); ?>"><?php echo esc_html( get_the_title( $post5 ) ); ?></a>
                                </h2>
                                <p class="discription">
                                    <?php
                                    $exc = get_the_excerpt( $post5 );
                                    if ( $exc === '' ) $exc = get_the_content( null, false, $post5 );
                                    echo esc_html( wp_trim_words( wp_strip_all_tags( $exc ), 18, '…' ) );
                                    ?>
                                </p>
                                <span class="author">
                                    <?php echo esc_html( get_the_date( 'F j', $post5 ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $post5->post_author ) ); ?>
                                </span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <hr class="vector" />
        <section class="card-wrap">
            <div class="nav-link">
                <h3>Explore</h3>
            </div>
            <div class="card-section">
                <div class="cards-grid">
                    <?php
                    $explore_count = 0;
                    foreach ( $explore_posts as $ep ) :
                        $explore_count++;
                        if ( $explore_count === 6 ) :
                    ?>
                    <div class="image">
                        <img src="<?php echo $ads_img; ?>" alt="advertisement" />
                    </div>
                    <?php endif; ?>
                    <div class="card-container">
                        <div class="card-img">
                            <?php if ( has_post_thumbnail( $ep ) ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $ep ) ); ?>">
                                    <?php echo get_the_post_thumbnail( $ep, 'medium', [ 'alt' => esc_attr( get_the_title( $ep ) ) ] ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="text-container">
                            <h2 class="title">
                                <a href="<?php echo esc_url( get_permalink( $ep ) ); ?>"><?php echo esc_html( get_the_title( $ep ) ); ?></a>
                            </h2>
                            <p class="discription">
                                <?php
                                $exc = get_the_excerpt( $ep );
                                if ( $exc === '' ) $exc = get_the_content( null, false, $ep );
                                echo esc_html( wp_trim_words( wp_strip_all_tags( $exc ), 20, '…' ) );
                                ?>
                            </p>
                            <span class="author">
                                <?php echo esc_html( get_the_date( 'F j', $ep ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $ep->post_author ) ); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
            $total_cat_posts = $cat_term ? $cat_term->count : 0;
            $shown_posts     = count( $featured_posts ) + count( $explore_posts );
            if ( $total_cat_posts > $shown_posts ) :
            ?>
            <a href="<?php echo esc_url( $cat_link ); ?>" class="btn">Load more</a>
            <?php endif; ?>
        </section>
    </div>
</main>

<div class="image-background" style="background-color: #8e8585">
    <div class="email-box">
        <h2 style="max-width: 413px !important">
            <?php esc_html_e( 'Subscribe to our newsletter to get weekly updates to your inbox.', 'theblotted' ); ?>
        </h2>
        <div class="email-container">
            <form action="#" method="post">
                <?php wp_nonce_field( 'theblotted_newsletter', 'newsletter_nonce' ); ?>
                <input
                    type="email"
                    name="newsletter-email"
                    autocomplete="email"
                    placeholder="<?php esc_attr_e( 'Email', 'theblotted' ); ?>"
                    required />
                <button type="submit"><?php esc_html_e( 'Subscribe', 'theblotted' ); ?></button>
            </form>
        </div>
    </div>
</div>
<div
    class="image-background img-height"
    style="
          background-image: url('<?php echo $ads_bg; ?>');
          background-blend-mode: multiply;
          background-size: cover;
          background-position: center;
        "></div>
