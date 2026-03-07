<?php

/**
 * Template part for a single Post
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theblotted
 */

// Post meta
$categories    = get_the_category();
$cat_label     = $categories ? $categories[0]->name : '';
$cat_link      = $categories ? get_term_link( $categories[0] ) : home_url( '/' );
$post_date     = get_the_date( 'F j' );
$author_name   = get_the_author();
$featured_url  = get_the_post_thumbnail_url( null, 'full' );

// ACF fields
$article_type     = function_exists( 'get_field' ) ? get_field( 'article_type' )     : '';
$article_subtitle = function_exists( 'get_field' ) ? get_field( 'article_subtitle' ) : '';
$mid_article_img  = function_exists( 'get_field' ) ? get_field( 'mid_article_image' ) : null;

// Use article_type ACF field to override the category label if set
$topic_label = ! empty( $article_type ) ? $article_type : $cat_label;

// Sidebar ad: use Options Page field, fall back to static asset
$ads_img = theblotted_acf_img_url(
    'global_sidebar_ad',
    theblotted_get_settings_page_id(),
    esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/Frame 46.png' )
);

// Related posts from same category
$related_posts = [];
if ( $categories ) {
    $related_query = new WP_Query(
        [
        'category__in'        => [ $categories[0]->term_id ],
        'posts_per_page'      => 4,
        'post__not_in'        => [ get_the_ID() ],
        'ignore_sticky_posts' => 1,
        'orderby'             => 'rand',
        ]
    );
    $related_posts = $related_query->posts;
    wp_reset_postdata();
}
?>

<main>
    <div class="app-wrapper">
        <!-- Article hero -->
        <section class="hero-section">
            <div class="topic">
                <div class="text-box">
                    <p class="card-topic">
                        <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $topic_label ); ?></a>
                    </p>
                    <h2 class="card-title"><?php the_title(); ?></h2>
                    <?php if ( $article_subtitle ) : ?>
                        <p class="card-subtitle"><?php echo esc_html( $article_subtitle ); ?></p>
                    <?php endif; ?>
                    <span class="card-author"><?php echo esc_html( $post_date ); ?> | <?php echo esc_html( $author_name ); ?></span>
                </div>
            </div>
            <?php if ( $featured_url ) : ?>
            <div
                class="image-background"
                style="
                background-image: url('<?php echo esc_url( $featured_url ); ?>');
                background-blend-mode: multiply;
                background-size: cover;
                background-position: center;
                width: 100%;
                height: 195px;
              "></div>
            <?php endif; ?>
        </section>
        <hr class="vector" />

        <!-- Article body + More Like This sidebar -->
        <section class="text-section">
            <div class="more-like-this">
                <div class="text-wrapper">
                    <!-- Article content -->
                    <div class="sub-text-container article-content">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- More Like This sidebar -->
                <?php if ( ! empty( $related_posts ) ) : ?>
                <div class="more-section">
                    <h3 class="more-title">MORE LIKE THIS</h3>
                    <div class="more-cards">
                        <?php foreach ( $related_posts as $idx => $rp ) : ?>
                        <div class="more-card">
                            <div class="more-card-image">
                                <?php if ( has_post_thumbnail( $rp ) ) : ?>
                                    <a href="<?php echo esc_url( get_permalink( $rp ) ); ?>">
                                        <?php echo get_the_post_thumbnail( $rp, 'thumbnail', [ 'alt' => esc_attr( get_the_title( $rp ) ) ] ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="more-card-text">
                                <?php
                                $rp_cats = get_the_category( $rp->ID );
                                $rp_cat  = $rp_cats ? $rp_cats[0]->name : '';
                                ?>
                                <p class="card-topic"><?php echo esc_html( $rp_cat ); ?></p>
                                <h4>
                                    <a href="<?php echo esc_url( get_permalink( $rp ) ); ?>">
                                        <?php echo esc_html( get_the_title( $rp ) ); ?>
                                    </a>
                                </h4>
                                <p class="card-author"><?php echo esc_html( get_the_author_meta( 'display_name', $rp->post_author ) ); ?></p>
                            </div>
                        </div>
                        <?php if ( $idx === 2 ) : ?>
                        <!-- Ad slot in sidebar -->
                        <div class="more-card-ad">
                            <img src="<?php echo $ads_img; ?>" alt="advertisement" />
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <hr class="vector" />

        <!-- Mid-article pull image (ACF: mid_article_image) -->
        <?php if ( $mid_article_img ) : ?>
        <section class="text-section">
            <div class="history-002">
                <div class="text-card-history-002">
                    <div class="section-cards-image">
                        <div class="image">
                            <img
                                src="<?php echo esc_url( $mid_article_img['url'] ); ?>"
                                alt="<?php echo esc_attr( $mid_article_img['alt'] ); ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <hr class="vector" />
        <?php endif; ?>

        <!-- Author bio -->
        <?php
        $author_id  = get_the_author_meta( 'ID' );
        $author_bio = get_the_author_meta( 'description' );
        ?>
        <?php if ( $author_bio ) : ?>
        <section class="contributor-section">
            <div class="contributors">
                <div>
                    <div class="contributor-image" style="width: 96px !important; height: 96px !important">
                        <?php echo get_avatar( $author_id, 96, '', esc_attr( $author_name ) ); ?>
                    </div>
                </div>
                <div class="contributor-text-box">
                    <h2 class="name"><?php echo esc_html( strtoupper( $author_name ) ); ?></h2>
                    <p class="discription"><?php echo esc_html( wp_trim_words( $author_bio, 25, '…' ) ); ?></p>
                </div>
            </div>
        </section>
        <hr class="vector" />
        <?php endif; ?>

        <!-- Newsletter -->
        <section class="newsletter-section">
            <div class="image-background" style="background-color: #8e8585; padding: 60px 20px;">
                <div class="email-box">
                    <h2><?php esc_html_e( 'Subscribe to our newsletter to get weekly updates to your inbox', 'theblotted' ); ?></h2>
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
        </section>

        <hr class="vector" />

        <!-- Comments -->
        <?php if ( comments_open() || get_comments_number() ) : ?>
        <section class="comments-section">
            <div class="comments-wrapper">
                <?php comments_template(); ?>
            </div>
        </section>
        <?php endif; ?>

    </div>
</main>
