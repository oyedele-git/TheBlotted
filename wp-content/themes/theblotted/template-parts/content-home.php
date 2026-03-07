<?php

/**
 * Template part for Homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

$next_link_img = esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/next-link.png' );
?>

<main>
  <div class="app-wrapper">
    <!-- desktop here -->
    <section class="hero-section">
      <div style="display: flex; flex-direction: column; width: 100%">
        <div class="topic-section">
          <div class="topic-container">
            <?php
            $sticky_posts = get_option( 'sticky_posts' );
            $rendered_post_ids = [];
            $topic_query = new WP_Query(
                [
                'post__not_in'        => $sticky_posts,
                'posts_per_page'      => 3,
                'ignore_sticky_posts' => 1,
                'orderby'             => 'date',
                'order'               => 'DESC',
                ]
            );
            ?>

            <?php if ( $topic_query->have_posts() ) : ?>
                <?php while ( $topic_query->have_posts() ) : $topic_query->the_post(); ?>
                    <?php
                    $rendered_post_ids[] = get_the_ID();
                    $categories          = get_the_category();
                    $topic_label         = $categories ? $categories[0]->name : '';
                    ?>
                <div class="topic-cards">
                  <div class="card-image">
                    <?php if ( has_post_thumbnail() ) : ?>
                      <a href="<?php echo esc_url( get_permalink() ); ?>">
                        <?php the_post_thumbnail( 'medium', [ 'alt' => esc_attr( get_the_title() ) ] ); ?>
                      </a>
                    <?php endif; ?>
                  </div>
                  <div class="text-box">
                    <p class="card-topic"><?php echo esc_html( $topic_label ); ?></p>
                    <h2 class="card-title">
                      <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
                    </h2>
                    <span class="card-author"><?php echo esc_html( get_the_author() ); ?></span>
                  </div>
                </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div id="top" class="wrap">
        <div class="home swiper">
          <div class="swiper-wrapper">
            <?php
            $sticky_query = new WP_Query(
                [
                'post__in'            => $sticky_posts,
                'posts_per_page'      => 3,
                'ignore_sticky_posts' => 1,
                'orderby'             => 'date',
                'order'               => 'DESC',
                ]
            );
            ?>

            <?php if ( $sticky_query->have_posts() ) : ?>
                <?php while ( $sticky_query->have_posts() ) : $sticky_query->the_post(); ?>
                    <?php $rendered_post_ids[] = get_the_ID(); ?>
                <div class="swiper-slide">
                  <a class="slide-link" href="<?php echo esc_url( get_permalink() ); ?>">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'full', [ 'class' => 'slide-bg', 'alt' => esc_attr( get_the_title() ) ] ); ?>
                    <?php endif; ?>
                    <div class="overlay"></div>
                    <div class="content">
                      <h1><?php the_title(); ?></h1>
                      <p>
                        <?php
                        $excerpt_source = get_the_excerpt();
                        if ( $excerpt_source === '' ) {
                            $excerpt_source = get_the_content();
                        }
                        echo esc_html( wp_trim_words( wp_strip_all_tags( $excerpt_source ), 15, '…' ) );
                        ?>
                      </p>
                    </div>
                  </a>
                </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
          </div>

          <!-- CUSTOM NAV BUTTONS -->
          <div class="butts">
            <span class="prev-btn swiper-button-prev"></span>
            <span class="next-btn swiper-button-next"></span>
          </div>
        </div>

        <!-- SWIPER PAGINATION DOTS -->
        <div class="navigation swiper-pagination"></div>
      </div>
    </section>
    <hr class="vector" />
    <section class="trending-container">
      <div class="nav-link">
        <h3>THE NEW</h3>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <h3>SEE MORE</h3>
          <img src="<?php echo $next_link_img; ?>" alt="" />
        </a>
      </div>
      <div class="trend-cards">
        <?php
        $new_query = new WP_Query(
            [
            'post__not_in'        => $rendered_post_ids,
            'posts_per_page'      => 5,
            'ignore_sticky_posts' => 1,
            'orderby'             => 'date',
            'order'               => 'DESC',
            ]
        );
        $new_posts = $new_query->posts;
        wp_reset_postdata();
        ?>
        <?php if ( ! empty( $new_posts ) ) : ?>
            <?php
            $primary_post = array_shift( $new_posts );
            $left_posts   = array_slice( $new_posts, 0, 2 );
            $right_posts  = array_slice( $new_posts, 2, 2 );
            $rendered_post_ids[] = $primary_post->ID;
            foreach ( $new_posts as $p ) {
                $rendered_post_ids[] = $p->ID;
            }
            ?>
          <div class="first-card">
            <div class="card-container">
              <div class="card-img">
                <?php if ( has_post_thumbnail( $primary_post ) ) : ?>
                  <a href="<?php echo esc_url( get_permalink( $primary_post ) ); ?>">
                    <?php echo get_the_post_thumbnail( $primary_post, 'large', [ 'alt' => esc_attr( get_the_title( $primary_post ) ) ] ); ?>
                  </a>
                <?php endif; ?>
              </div>
              <div class="text-container">
                <h2 class="title">
                  <a href="<?php echo esc_url( get_permalink( $primary_post ) ); ?>">
                    <?php echo esc_html( get_the_title( $primary_post ) ); ?>
                  </a>
                </h2>
                <p class="discription">
                  <?php
                    $excerpt_source = get_the_excerpt( $primary_post );
                    if ( $excerpt_source === '' ) {
                        $excerpt_source = get_the_content( null, false, $primary_post );
                    }
                    echo esc_html( wp_trim_words( wp_strip_all_tags( $excerpt_source ), 25, '…' ) );
                    ?>
                </p>
                <span class="author">
                  <?php echo esc_html( get_the_date( 'F j', $primary_post ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $primary_post->post_author ) ); ?>
                </span>
              </div>
            </div>
          </div>
          <div class="second-card">
            <div>
              <?php foreach ( $left_posts as $index => $post ) : ?>
                <div class="card-container <?php echo $index === 0 ? 'card-1' : 'card-2'; ?>">
                  <div class="card-img">
                    <?php if ( has_post_thumbnail( $post ) ) : ?>
                      <a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
                        <?php echo get_the_post_thumbnail( $post, 'medium', [ 'alt' => esc_attr( get_the_title( $post ) ) ] ); ?>
                      </a>
                    <?php endif; ?>
                  </div>
                  <div class="text-container">
                    <h2 class="title">
                      <a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
                        <?php echo esc_html( get_the_title( $post ) ); ?>
                      </a>
                    </h2>
                    <p class="discription">
                      <?php
                        $excerpt_source = get_the_excerpt( $post );
                        if ( $excerpt_source === '' ) {
                            $excerpt_source = get_the_content( null, false, $post );
                        }
                        echo esc_html( wp_trim_words( wp_strip_all_tags( $excerpt_source ), 18, '…' ) );
                        ?>
                    </p>
                    <span class="author">
                      <?php echo esc_html( get_the_date( 'F j', $post ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?>
                    </span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <div>
              <?php foreach ( $right_posts as $index => $post ) : ?>
                <div class="card-container <?php echo $index === 0 ? 'card-1' : 'card-2'; ?>">
                  <div class="card-img">
                    <?php if ( has_post_thumbnail( $post ) ) : ?>
                      <a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
                        <?php echo get_the_post_thumbnail( $post, 'medium', [ 'alt' => esc_attr( get_the_title( $post ) ) ] ); ?>
                      </a>
                    <?php endif; ?>
                  </div>
                  <div class="text-container">
                    <h2 class="title">
                      <a href="<?php echo esc_url( get_permalink( $post ) ); ?>">
                        <?php echo esc_html( get_the_title( $post ) ); ?>
                      </a>
                    </h2>
                    <p class="discription">
                      <?php
                        $excerpt_source = get_the_excerpt( $post );
                        if ( $excerpt_source === '' ) {
                            $excerpt_source = get_the_content( null, false, $post );
                        }
                        echo esc_html( wp_trim_words( wp_strip_all_tags( $excerpt_source ), 18, '…' ) );
                        ?>
                    </p>
                    <span class="author">
                      <?php echo esc_html( get_the_date( 'F j', $post ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $post->post_author ) ); ?>
                    </span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>
    <hr class="vector" />
    <section class="popular-container">
      <div class="nav-link">
        <h3>POPULAR</h3>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <h3>SEE MORE</h3>
          <img src="<?php echo $next_link_img; ?>" alt="" />
        </a>
      </div>
      <?php
        $popular_ids = function_exists( 'wpp_get_ids' )
        ? wpp_get_ids(
            [
            'limit'         => 5,
            'range'         => 'custom',
            'time_unit'     => 'day',
            'time_quantity' => 14,
            'post_type'     => 'post',
            'order_by'      => 'views',
            ]
        )
        : [];
        $popular_posts = [];

        if ( ! empty( $popular_ids ) ) {
            $popular_query = new WP_Query(
                [
                'post_type'      => 'post',
                'post__in'       => $popular_ids,
                'orderby'        => 'post__in',
                'posts_per_page' => count( $popular_ids ),
                ]
            );
            $popular_posts = $popular_query->posts;
            wp_reset_postdata();
        }

        $popular_hero         = ! empty( $popular_posts ) ? array_shift( $popular_posts ) : null;
        $popular_default_hero = THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/background.png';
        $popular_default_thumb = THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/image 12.png';
        ?>
      <?php if ( $popular_hero ) : ?>
            <?php
            $hero_image      = get_the_post_thumbnail_url( $popular_hero, 'full' );
            $hero_image      = $hero_image ? $hero_image : $popular_default_hero;
            $hero_categories = get_the_category( $popular_hero->ID );
            $hero_category   = ! empty( $hero_categories ) ? $hero_categories[0]->name : 'Popular';
            $hero_excerpt    = get_the_excerpt( $popular_hero );
            if ( $hero_excerpt === '' ) {
                $hero_excerpt = get_the_content( null, false, $popular_hero );
            }
            ?>
        <a class="popular-hero-link" href="<?php echo esc_url( get_permalink( $popular_hero ) ); ?>">
          <div
            class="image-background"
            style="
                  background-image: linear-gradient(
                      1.76deg,
                      #251d14 1.49%,
                      rgba(37, 29, 20, 0) 99.95%
                    ),
                    url('<?php echo esc_url( $hero_image ); ?>');
                  background-size: cover;
                  background-position: center;
                ">
            <div class="text-container">
              <span class="author"><?php echo esc_html( $hero_category ); ?></span>
              <h2 class="title">
                <span><?php echo esc_html( get_the_title( $popular_hero ) ); ?></span>
              </h2>
              <p class="discription">
                <?php echo esc_html( wp_trim_words( wp_strip_all_tags( $hero_excerpt ), 24, '…' ) ); ?>
              </p>
              <span class="author"><?php echo esc_html( get_the_date( 'F j', $popular_hero ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $popular_hero->post_author ) ); ?></span>
            </div>
          </div>
        </a>
      <?php endif; ?>
      <?php if ( ! empty( $popular_posts ) ) : ?>
        <div class="popular-section">
          <div class="popular-cards" id="popular-cards">
            <?php foreach ( array_slice( $popular_posts, 0, 4 ) as $popular_post ) : ?>
                <?php
                $card_excerpt = get_the_excerpt( $popular_post );
                if ( $card_excerpt === '' ) {
                    $card_excerpt = get_the_content( null, false, $popular_post );
                }
                $card_image = get_the_post_thumbnail_url( $popular_post, 'medium' );
                $card_image = $card_image ? $card_image : $popular_default_thumb;
                ?>
              <div class="card-container">
                <div class="card-img">
                  <a href="<?php echo esc_url( get_permalink( $popular_post ) ); ?>">
                    <img src="<?php echo esc_url( $card_image ); ?>" alt="<?php echo esc_attr( get_the_title( $popular_post ) ); ?>" />
                  </a>
                </div>
                <div class="text-container">
                  <h2 class="title">
                    <a href="<?php echo esc_url( get_permalink( $popular_post ) ); ?>">
                      <?php echo esc_html( get_the_title( $popular_post ) ); ?>
                    </a>
                  </h2>
                  <p class="discription">
                    <?php echo esc_html( wp_trim_words( wp_strip_all_tags( $card_excerpt ), 18, '…' ) ); ?>
                  </p>
                  <span class="author"><?php echo esc_html( get_the_date( 'F j', $popular_post ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $popular_post->post_author ) ); ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </section>

    <!-- ads -->
    <hr class="vector" />
    <?php
    $home_mid_ad = theblotted_acf_img_url(
        'home_mid_banner_ad',
        theblotted_get_settings_page_id(),
        esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/ads-image.jpg' )
    );
    ?>
    <div
      class="image-background img-height"
      style="
              background-image: url('<?php echo $home_mid_ad; ?>');
              background-blend-mode: multiply;
              background-size: cover;
              background-position: center;
            "></div>
    <hr class="vector" />

    <?php
    // Helper: render a standard 4-card category section
    $theblotted_home_sections = [
        [
            'slug'  => 'issues',
            'label' => 'Issues',
            'count' => 3,
            'ad'    => true,
        ],
        [
            'slug'  => 'literature',
            'label' => 'Literature',
            'count' => 4,
            'ad'    => false,
        ],
        [
            'slug'  => 'pop-of-culture',
            'label' => 'Pop of Culture',
            'count' => 4,
            'ad'    => false,
        ],
        [
            'slug'  => 'lifestyle',
            'label' => 'Lifestyle',
            'count' => 4,
            'ad'    => false,
        ],
        [
            'slug'  => 'politics',
            'label' => 'Politics',
            'count' => 4,
            'ad'    => false,
        ],
    ];

    foreach ( $theblotted_home_sections as $section ) :
        $s_term  = get_term_by( 'slug', $section['slug'], 'category' );
        $s_link  = $s_term ? get_term_link( $s_term ) : home_url( '/' );
        $s_query = new WP_Query(
            [
            'category_name'       => $section['slug'],
            'posts_per_page'      => $section['count'],
            'post__not_in'        => $rendered_post_ids,
            'ignore_sticky_posts' => 1,
            'orderby'             => 'date',
            'order'               => 'DESC',
            ]
        );
        if ( ! $s_query->have_posts() ) {
            wp_reset_postdata();
            continue;
        }
    ?>
    <section class="card-wrap">
      <div class="nav-link">
        <h3><?php echo esc_html( $section['label'] ); ?></h3>
        <a href="<?php echo esc_url( $s_link ); ?>">
          <h3>SEE MORE</h3>
          <img src="<?php echo $next_link_img; ?>" alt="" />
        </a>
      </div>
      <div class="card-section">
        <div class="cards-grid">
          <?php
          $s_post_index = 0;
          while ( $s_query->have_posts() ) :
              $s_query->the_post();
              $s_post_index++;
              // Insert ad slot after first post for "issues" section
              if ( $section['ad'] && $s_post_index === 2 ) :
          ?>
          <div class="image">
            <img src="<?php echo theblotted_acf_img_url( 'home_issues_section_ad', theblotted_get_settings_page_id(), esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/friday-sales.png' ) ); ?>" alt="advertisement" />
          </div>
          <?php endif; ?>
          <div class="card-container">
            <div class="card-img">
              <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php echo esc_url( get_permalink() ); ?>">
                  <?php the_post_thumbnail( 'medium', [ 'alt' => esc_attr( get_the_title() ) ] ); ?>
                </a>
              <?php endif; ?>
            </div>
            <div class="text-container">
              <h2 class="title">
                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
              </h2>
              <p class="discription">
                <?php
                $s_excerpt = get_the_excerpt();
                if ( $s_excerpt === '' ) {
                    $s_excerpt = get_the_content();
                }
                echo esc_html( wp_trim_words( wp_strip_all_tags( $s_excerpt ), 20, '…' ) );
                ?>
              </p>
              <span class="author">
                <?php echo esc_html( get_the_date( 'F j' ) ); ?> | <?php echo esc_html( get_the_author() ); ?>
              </span>
            </div>
          </div>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>
    </section>
    <hr class="vector" />
    <?php endforeach; ?>

    <!-- Cartoons and Crosswords -->
    <?php
    $cartoons_term = get_term_by( 'slug', 'cartoons-crosswords', 'category' );
    if ( ! $cartoons_term ) {
        $cartoons_term = get_term_by( 'slug', 'cartoons', 'category' );
    }
    $cartoons_link = $cartoons_term ? get_term_link( $cartoons_term ) : home_url( '/' );

    $cartoons_query = new WP_Query(
        [
        'posts_per_page'      => 5,
        'post__not_in'        => $rendered_post_ids,
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
            [
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => 'cartoons-crosswords',
            ],
        ],
        ]
    );
    $cartoons_posts = $cartoons_query->posts;
    wp_reset_postdata();
    $cartoons_main   = isset( $cartoons_posts[0] ) ? $cartoons_posts[0] : null;
    $cartoons_side   = array_slice( $cartoons_posts, 1, 4 );
    ?>
    <?php if ( $cartoons_main ) : ?>
    <section class="cartoon-container">
      <div class="nav-link">
        <h3>Cartoons and Crosswords</h3>
        <a href="<?php echo esc_url( $cartoons_link ); ?>">
          <h3>SEE MORE</h3>
          <img src="<?php echo $next_link_img; ?>" alt="" />
        </a>
      </div>
      <div class="cartoon-cards">
        <!-- first image hidden on mobile -->
        <div class="first-cartoon-card">
          <div class="card-cartoon-container">
            <div class="card-img">
              <?php if ( has_post_thumbnail( $cartoons_main ) ) : ?>
                <a href="<?php echo esc_url( get_permalink( $cartoons_main ) ); ?>">
                  <?php echo get_the_post_thumbnail( $cartoons_main, 'large', [ 'alt' => esc_attr( get_the_title( $cartoons_main ) ) ] ); ?>
                </a>
              <?php endif; ?>
            </div>
            <div class="text-container">
              <h2 class="title">
                <a href="<?php echo esc_url( get_permalink( $cartoons_main ) ); ?>">
                  <?php echo esc_html( get_the_title( $cartoons_main ) ); ?>
                </a>
              </h2>
              <p class="discription">
                <?php
                $c_excerpt = get_the_excerpt( $cartoons_main );
                if ( $c_excerpt === '' ) $c_excerpt = get_the_content( null, false, $cartoons_main );
                echo esc_html( wp_trim_words( wp_strip_all_tags( $c_excerpt ), 20, '…' ) );
                ?>
              </p>
              <span class="author">
                <?php echo esc_html( get_the_date( 'F j', $cartoons_main ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $cartoons_main->post_author ) ); ?>
              </span>
            </div>
          </div>
        </div>
        <!-- side cards -->
        <div class="second-card">
          <?php
          $cartoons_chunk1 = array_slice( $cartoons_side, 0, 2 );
          $cartoons_chunk2 = array_slice( $cartoons_side, 2, 2 );
          foreach ( [ $cartoons_chunk1, $cartoons_chunk2 ] as $chunk ) :
          ?>
          <div class="first-cartoon-child">
            <?php foreach ( $chunk as $idx => $c_post ) : ?>
            <div class="card-cartoon-container <?php echo $idx === 0 ? 'card-1' : 'card-2'; ?>">
              <div class="card-img">
                <?php if ( has_post_thumbnail( $c_post ) ) : ?>
                  <a href="<?php echo esc_url( get_permalink( $c_post ) ); ?>">
                    <?php echo get_the_post_thumbnail( $c_post, 'medium', [ 'alt' => esc_attr( get_the_title( $c_post ) ) ] ); ?>
                  </a>
                <?php endif; ?>
              </div>
              <div class="text-container">
                <h2 class="title">
                  <a href="<?php echo esc_url( get_permalink( $c_post ) ); ?>">
                    <?php echo esc_html( get_the_title( $c_post ) ); ?>
                  </a>
                </h2>
                <p class="discription">
                  <?php
                  $cs_excerpt = get_the_excerpt( $c_post );
                  if ( $cs_excerpt === '' ) $cs_excerpt = get_the_content( null, false, $c_post );
                  echo esc_html( wp_trim_words( wp_strip_all_tags( $cs_excerpt ), 15, '…' ) );
                  ?>
                </p>
                <span class="author">
                  <?php echo esc_html( get_the_date( 'F j', $c_post ) ); ?> | <?php echo esc_html( get_the_author_meta( 'display_name', $c_post->post_author ) ); ?>
                </span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <hr class="vector" />
    <?php endif; ?>
    <!-- Cartoons and Crosswords -->

    <!-- Contributors -->
    <?php
    $contributors = get_users(
        [
        'role__in' => [ 'author', 'editor', 'administrator', 'contributor' ],
        'number'   => 4,
        'orderby'  => 'post_count',
        'order'    => 'DESC',
        ]
    );
    ?>
    <?php if ( ! empty( $contributors ) ) : ?>
    <section class="card-wrap" style="margin-bottom: 30px;">
      <div class="nav-link">
        <h3>CONTRIBUTORS</h3>
      </div>
      <div class="card-section">
        <div class="cards-grid">
          <?php foreach ( $contributors as $contributor ) : ?>
          <div class="contributors">
            <div>
              <div class="contributor-image" style="width: 96px !important; height: 96px !important">
                <?php echo get_avatar( $contributor->ID, 96, '', esc_attr( $contributor->display_name ) ); ?>
              </div>
            </div>
            <div class="contributor-text-box">
              <h2 class="name"><?php echo esc_html( $contributor->display_name ); ?></h2>
              <p class="discription">
                <?php
                $bio = get_the_author_meta( 'description', $contributor->ID );
                echo esc_html( wp_trim_words( $bio, 20, '…' ) );
                ?>
              </p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <?php endif; ?>
  </div>
</main>

<!-- Reusable Topic Card Template -->
<template id="topic-card-template">
  <div class="topic-cards">
    <div class="card-image">
      <img src="" alt="card-image" />
    </div>
    <div class="text-box">
      <p class="card-topic"></p>
      <h2 class="card-title"></h2>
      <span class="card-author"></span>
    </div>
  </div>
</template>

<!-- Newsletter -->
<div
  class="image-background"
  style="
          background-color: #8e8585;
          padding-top: 100px;
          padding-bottom: 100px;
          width: 100%;
        ">
  <div class="email-box" style="width: 273px">
    <h2 style="font-size: 24px">
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
