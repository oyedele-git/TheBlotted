<?php

/**
 * Template part for Cartoons and Crosswords Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theblotted
 */

// Category links
$cartoons_term    = get_term_by( 'slug', 'cartoons', 'category' );
$crosswords_term  = get_term_by( 'slug', 'crosswords', 'category' );
$cartoons_link    = $cartoons_term ? get_term_link( $cartoons_term ) : home_url( '/' );
$crosswords_link  = $crosswords_term ? get_term_link( $crosswords_term ) : home_url( '/' );
$next_link_img    = esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/next-link.png' );
$ads_bg           = theblotted_acf_img_url( 'global_banner_ad', theblotted_get_settings_page_id(), esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/Frame 455.png' ) );

/**
 * Helper: query featured posts for a given category slug (5 posts).
 */
function theblotted_get_cat_featured( $slug ) {
    $q = new WP_Query(
        [
        'category_name'       => $slug,
        'posts_per_page'      => 5,
        'ignore_sticky_posts' => 1,
        'orderby'             => 'date',
        'order'               => 'DESC',
        ]
    );
    $posts = $q->posts;
    wp_reset_postdata();
    return $posts;
}

// Cartoons: use ACF pinned posts if set, fall back to WP_Query
$cartoons_posts = [];
if ( function_exists( 'get_field' ) ) {
    $acf_cartoons = get_field( 'featured_cartoons' );
    if ( ! empty( $acf_cartoons ) ) {
        $cartoons_posts = $acf_cartoons;
    }
}
if ( empty( $cartoons_posts ) ) {
    $cartoons_posts = theblotted_get_cat_featured( 'cartoons' );
}

// Crosswords: use ACF pinned posts if set, fall back to WP_Query
$crosswords_posts = [];
if ( function_exists( 'get_field' ) ) {
    $acf_crosswords = get_field( 'featured_crosswords' );
    if ( ! empty( $acf_crosswords ) ) {
        $crosswords_posts = $acf_crosswords;
    }
}
if ( empty( $crosswords_posts ) ) {
    $crosswords_posts = theblotted_get_cat_featured( 'crosswords' );
}

/**
 * Render a lifestyle-style card section for a list of 5 posts.
 */
function theblotted_render_lifestyle_cards( $posts ) {
    $p1 = isset( $posts[0] ) ? $posts[0] : null;
    $p2 = isset( $posts[1] ) ? $posts[1] : null;
    $p3 = isset( $posts[2] ) ? $posts[2] : null;
    $p4 = isset( $posts[3] ) ? $posts[3] : null;
    ?>
    <div class="lifestyle-cards">
        <div class="first-card">
            <?php if ( $p1 ) : ?>
            <div class="card-container">
                <div class="card-img">
                    <?php if ( has_post_thumbnail( $p1 ) ) : ?>
                        <a href="<?php echo esc_url( get_permalink( $p1 ) ); ?>">
                            <?php echo get_the_post_thumbnail( $p1, 'large', [ 'alt' => esc_attr( get_the_title( $p1 ) ) ] ); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="text-container">
                    <h2 class="title">
                        <a href="<?php echo esc_url( get_permalink( $p1 ) ); ?>"><?php echo esc_html( get_the_title( $p1 ) ); ?></a>
                    </h2>
                    <p class="discription">
                        <?php
                        $exc = get_the_excerpt( $p1 );
                        if ( $exc === '' ) $exc = get_the_content( null, false, $p1 );
                        echo esc_html( wp_trim_words( wp_strip_all_tags( $exc ), 25, '…' ) );
                        ?>
                    </p>
                    <span class="author">
                        <?php echo esc_html( get_the_date( 'F j', $p1 ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $p1->post_author ) ); ?>
                    </span>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="second-card">
            <div>
                <?php foreach ( [ $p2, $p3 ] as $idx => $p ) : ?>
                    <?php if ( $p ) : ?>
                    <div class="card-container card-1">
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
                            <p class="discription hide">
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
                <?php if ( $p4 ) : ?>
                <div class="card-container card-1">
                    <div class="card-img">
                        <?php if ( has_post_thumbnail( $p4 ) ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $p4 ) ); ?>">
                                <?php echo get_the_post_thumbnail( $p4, 'medium', [ 'alt' => esc_attr( get_the_title( $p4 ) ) ] ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="text-container">
                        <h2 class="title">
                            <a href="<?php echo esc_url( get_permalink( $p4 ) ); ?>"><?php echo esc_html( get_the_title( $p4 ) ); ?></a>
                        </h2>
                        <p class="discription hide">
                            <?php
                            $exc = get_the_excerpt( $p4 );
                            if ( $exc === '' ) $exc = get_the_content( null, false, $p4 );
                            echo esc_html( wp_trim_words( wp_strip_all_tags( $exc ), 18, '…' ) );
                            ?>
                        </p>
                        <span class="author">
                            <?php echo esc_html( get_the_date( 'F j', $p4 ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $p4->post_author ) ); ?>
                        </span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}
?>

<main>
    <div class="app-wrapper">
        <!-- desktop -->
        <!-- CARTOONS SECTION -->
        <section class="lifestyle-container">
            <div class="nav-link hide">
                <h3>Recent</h3>
            </div>
            <div class="nav-link show">
                <h3>CARTOONS</h3>
                <a href="<?php echo esc_url( $cartoons_link ); ?>">
                    <h3>SEE MORE</h3>
                    <img src="<?php echo $next_link_img; ?>" alt="" />
                </a>
            </div>
            <?php theblotted_render_lifestyle_cards( $cartoons_posts ); ?>
        </section>

        <hr class="vector show" />

        <!-- CROSSWORDS SECTION -->
        <section class="lifestyle-container show">
            <div class="nav-link">
                <h3>CROSSWORDS</h3>
                <a href="<?php echo esc_url( $crosswords_link ); ?>">
                    <h3>SEE MORE</h3>
                    <img src="<?php echo $next_link_img; ?>" alt="" />
                </a>
            </div>
            <?php theblotted_render_lifestyle_cards( $crosswords_posts ); ?>
        </section>

        <hr class="vector show" />

        <!-- Newsletter (desktop) -->
        <section class="section-flex show">
            <div class="image-background">
                <div class="email-box">
                    <h2>
                        <?php esc_html_e( 'Our daily crossword puzzles, which range from beginner-friendly to challenging, plus cryptics, quizzes and other brain-teasing games', 'theblotted' ); ?>
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
        </section>

        <hr class="vector show" />

        <!-- Ads (desktop) -->
        <section class="section-flex show">
            <div
                class="image-background"
                style="
                background-image: url('<?php echo $ads_bg; ?>');
                background-blend-mode: multiply;
                background-size: cover;
                background-position: center;
                height: 250px;
              "></div>
        </section>

        <hr class="vector show" />

        <!-- Contributors -->
        <?php
        $contributors = get_users(
            [
            'role__in' => [ 'author', 'editor', 'administrator', 'contributor' ],
            'number'   => 1,
            'orderby'  => 'post_count',
            'order'    => 'DESC',
            ]
        );
        if ( ! empty( $contributors ) ) :
            $c = $contributors[0];
        ?>
        <section class="section-flex show">
            <div class="contributors">
                <div>
                    <div class="contributor-image" style="width: 96px !important; height: 96px !important">
                        <?php echo get_avatar( $c->ID, 96, '', esc_attr( $c->display_name ) ); ?>
                    </div>
                </div>
                <div class="contributor-text-box">
                    <h2 class="name"><?php echo esc_html( $c->display_name ); ?></h2>
                    <p class="discription">
                        <?php echo esc_html( wp_trim_words( get_the_author_meta( 'description', $c->ID ), 20, '…' ) ); ?>
                    </p>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <hr class="vector" />
        <!-- desktop -->

        <!-- Mobile explore cards -->
        <?php
        $all_cc_ids = array_column( $cartoons_posts, 'ID' );
        foreach ( $crosswords_posts as $xp ) {
            $all_cc_ids[] = $xp->ID;
        }
        $mobile_query = new WP_Query(
            [
            'posts_per_page'      => 11,
            'post__not_in'        => $all_cc_ids,
            'ignore_sticky_posts' => 1,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'tax_query'           => [
                'relation' => 'OR',
                [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => 'cartoons',
                ],
                [
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => 'crosswords',
                ],
            ],
            ]
        );
        $mobile_posts = $mobile_query->posts;
        wp_reset_postdata();
        ?>
        <section class="card-wrap hide">
            <div class="nav-link">
                <h3>Explore</h3>
            </div>
            <div class="card-section">
                <div class="cards-grid">
                    <?php
                    $m_count = 0;
                    foreach ( $mobile_posts as $mp ) :
                        $m_count++;
                        if ( $m_count === 6 ) :
                    ?>
                    <div
                        class="image-background img-height"
                        style="
                        background-image: url('<?php echo $ads_bg; ?>');
                        background-blend-mode: multiply;
                        background-size: cover;
                        background-position: center;
                      "></div>
                    <?php endif; ?>
                    <div class="card-container">
                        <div class="card-img">
                            <?php if ( has_post_thumbnail( $mp ) ) : ?>
                                <a href="<?php echo esc_url( get_permalink( $mp ) ); ?>">
                                    <?php echo get_the_post_thumbnail( $mp, 'medium', [ 'alt' => esc_attr( get_the_title( $mp ) ) ] ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="text-container">
                            <h2 class="title">
                                <a href="<?php echo esc_url( get_permalink( $mp ) ); ?>"><?php echo esc_html( get_the_title( $mp ) ); ?></a>
                            </h2>
                            <p class="discription">
                                <?php
                                $exc = get_the_excerpt( $mp );
                                if ( $exc === '' ) $exc = get_the_content( null, false, $mp );
                                echo esc_html( wp_trim_words( wp_strip_all_tags( $exc ), 20, '…' ) );
                                ?>
                            </p>
                            <span class="author">
                                <?php echo esc_html( get_the_date( 'F j', $mp ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $mp->post_author ) ); ?>
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <hr class="vector hide" />
        <!-- mobile card -->
    </div>
</main>

<!-- Mobile newsletter -->
<div class="image-background" style="background-color: #8e8585">
    <div class="email-box">
        <h2 style="width: 300px; line-height: 20px">
            <?php esc_html_e( 'Our daily crossword puzzles, which range from beginner-friendly to challenging, plus cryptics, quizzes and other brain-teasing games', 'theblotted' ); ?>
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

<!-- Mobile ads -->
<div
    class="image-background img-height"
    style="
          background-image: url('<?php echo $ads_bg; ?>');
          background-blend-mode: multiply;
          background-size: cover;
          background-position: center;
          height: 111px;
          border-top: 40px solid #fbf6ee !important;
        "></div>
