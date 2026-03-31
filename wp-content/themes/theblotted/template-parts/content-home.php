<?php
/**
 * Template part for Homepage
 * Based on theblotted-header-v2.html structure.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package theblotted
 */

$rendered_post_ids = [];

// ── Helper: get excerpt safely ──
function theblotted_home_excerpt( $post_obj, $words = 20 ) {
    $src = get_the_excerpt( $post_obj );
    if ( $src === '' ) {
        $src = get_the_content( null, false, $post_obj );
    }
    return esc_html( wp_trim_words( wp_strip_all_tags( $src ), $words, '…' ) );
}

// ── Sticky posts for hero slider (up to 3) ──
$sticky_ids   = get_option( 'sticky_posts', [] );
$slider_query = new WP_Query( [
    'post__in'            => ! empty( $sticky_ids ) ? $sticky_ids : [0],
    'posts_per_page'      => 3,
    'ignore_sticky_posts' => 1,
    'orderby'             => 'date',
    'order'               => 'DESC',
] );

// Fallback: if not enough sticky posts, pad with latest
if ( $slider_query->post_count < 3 ) {
    $slider_query = new WP_Query( [
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => 1,
        'orderby'             => 'date',
        'order'               => 'DESC',
    ] );
}

$slider_posts = $slider_query->posts;
wp_reset_postdata();

foreach ( $slider_posts as $sp ) {
    $rendered_post_ids[] = $sp->ID;
}

// ── Pre-hero strip: 3 posts (desktop) ──
$prehero_query = new WP_Query( [
    'posts_per_page'      => 3,
    'post__not_in'        => $rendered_post_ids,
    'ignore_sticky_posts' => 1,
    'orderby'             => 'date',
    'order'               => 'DESC',
] );
$prehero_posts = $prehero_query->posts;
wp_reset_postdata();
foreach ( $prehero_posts as $ph_p ) {
    $rendered_post_ids[] = $ph_p->ID;
}
?>

<!-- DESKTOP PRE-HERO STRIP (in page flow, scrolls with page) -->
<div class="pre-hero-wrap">
  <div class="pre-hero">

    <?php foreach ( $prehero_posts as $ph_post ) :
        $ph_cats  = get_the_category( $ph_post->ID );
        $ph_label = $ph_cats ? $ph_cats[0]->name : '';
        $ph_thumb = get_the_post_thumbnail_url( $ph_post->ID, 'thumbnail' );
    ?>
    <div class="pre-hero-card">
      <a href="<?php echo esc_url( get_permalink( $ph_post ) ); ?>" class="pre-hero-thumb">
        <?php if ( $ph_thumb ) : ?>
          <img class="ph" src="<?php echo esc_url( $ph_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $ph_post ) ); ?>" />
        <?php else : ?>
          <div class="ph ph-1"></div>
        <?php endif; ?>
      </a>
      <div class="pre-hero-text">
        <span class="topic-label"><?php echo esc_html( $ph_label ); ?></span>
        <a href="<?php echo esc_url( get_permalink( $ph_post ) ); ?>" class="post-title"><?php echo esc_html( get_the_title( $ph_post ) ); ?></a>
        <div class="post-author"><?php echo esc_html( get_the_author_meta( 'display_name', $ph_post->post_author ) ); ?></div>
      </div>
    </div>
    <?php endforeach; ?>

    <?php if ( ! empty( $prehero_posts[2] ) ) :
        $ph3_post  = $prehero_posts[2];
        $ph3_cats  = get_the_category( $ph3_post->ID );
        $ph3_label = $ph3_cats ? $ph3_cats[0]->name : '';
        $ph3_thumb = get_the_post_thumbnail_url( $ph3_post->ID, 'thumbnail' );
    ?>
    <div class="pre-hero-card">
      <a href="<?php echo esc_url( get_permalink( $ph3_post ) ); ?>" class="pre-hero-thumb">
        <?php if ( $ph3_thumb ) : ?>
          <img class="ph" src="<?php echo esc_url( $ph3_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $ph3_post ) ); ?>" />
        <?php else : ?>
          <div class="ph ph-1"></div>
        <?php endif; ?>
      </a>
      <div class="pre-hero-text">
        <span class="topic-label"><?php echo esc_html( $ph3_label ); ?></span>
        <a href="<?php echo esc_url( get_permalink( $ph3_post ) ); ?>" class="post-title"><?php echo esc_html( get_the_title( $ph3_post ) ); ?></a>
        <div class="post-author"><?php echo esc_html( get_the_author_meta( 'display_name', $ph3_post->post_author ) ); ?></div>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<!-- MOBILE: active slide title above hero image -->
<div class="mobile-slide-header" id="mobile-slide-header">
  <?php if ( ! empty( $slider_posts ) ) :
      $first_slide = $slider_posts[0]; ?>
  <h2 id="mob-title"><?php echo esc_html( get_the_title( $first_slide ) ); ?></h2>
  <p id="mob-desc"><?php echo theblotted_home_excerpt( $first_slide, 25 ); ?></p>
  <?php endif; ?>
</div>

<!-- HERO SLIDER (full bleed, in page flow) -->
<div class="hero-wrap">
  <div class="hero-slider" id="hero-slider">

    <?php foreach ( $slider_posts as $idx => $slide_post ) :
        $slide_img   = get_the_post_thumbnail_url( $slide_post->ID, 'full' );
        $slide_title = get_the_title( $slide_post );
        $slide_desc  = wp_trim_words( wp_strip_all_tags( get_the_excerpt( $slide_post ) ?: get_the_content( null, false, $slide_post ) ), 25, '…' );
        $slide_class = $idx === 0 ? 'slide active' : 'slide';
        $bg_class    = 'slide-bg-' . ( ( $idx % 3 ) + 1 );
    ?>
    <div class="<?php echo esc_attr( $slide_class ); ?>"
         data-title="<?php echo esc_attr( $slide_title ); ?>"
         data-desc="<?php echo esc_attr( $slide_desc ); ?>"
         data-url="<?php echo esc_url( get_permalink( $slide_post ) ); ?>">
      <?php if ( $slide_img ) : ?>
        <img class="slide-bg" src="<?php echo esc_url( $slide_img ); ?>" alt="<?php echo esc_attr( $slide_title ); ?>" />
      <?php else : ?>
        <div class="slide-bg <?php echo esc_attr( $bg_class ); ?>"></div>
      <?php endif; ?>
      <div class="slide-overlay"></div>
      <a href="<?php echo esc_url( get_permalink( $slide_post ) ); ?>" class="slide-content">
        <h1><?php echo esc_html( $slide_title ); ?></h1>
        <p><?php echo esc_html( $slide_desc ); ?></p>
      </a>
    </div>
    <?php endforeach; ?>

    <button class="slide-arrow prev" onclick="changeSlide(-1)" aria-label="<?php esc_attr_e( 'Previous slide', 'theblotted' ); ?>">&#8249;</button>
    <button class="slide-arrow next" onclick="changeSlide(1)" aria-label="<?php esc_attr_e( 'Next slide', 'theblotted' ); ?>">&#8250;</button>

  </div><!-- /hero-slider -->

  <!-- MOBILE: slide title + desc below image -->
  <div class="mobile-slide-footer" id="mob-footer">
    <?php if ( ! empty( $slider_posts ) ) : ?>
    <a id="mob-footer-link" href="<?php echo esc_url( get_permalink( $slider_posts[0] ) ); ?>">
      <h2 id="mob-footer-title"><?php echo esc_html( get_the_title( $slider_posts[0] ) ); ?></h2>
      <p id="mob-footer-desc"><?php echo theblotted_home_excerpt( $slider_posts[0], 25 ); ?></p>
    </a>
    <?php endif; ?>
  </div>
</div><!-- /hero-wrap -->

<!-- ═══════════════════════════════════════════════════
     MAIN PAGE CONTENT
══════════════════════════════════════════════════════ -->
<main id="main-content">

<?php
// ── Trending posts: 5 (1 big + 2 + 2) ──
$trending_query = new WP_Query( [
    'posts_per_page'      => 5,
    'post__not_in'        => $rendered_post_ids,
    'ignore_sticky_posts' => 1,
    'orderby'             => 'date',
    'order'               => 'DESC',
] );
$trending_posts = $trending_query->posts;
wp_reset_postdata();
foreach ( $trending_posts as $tp ) {
    $rendered_post_ids[] = $tp->ID;
}
$trend_big   = isset( $trending_posts[0] ) ? $trending_posts[0] : null;
$trend_mid   = array_slice( $trending_posts, 1, 2 );
$trend_right = array_slice( $trending_posts, 3, 2 );
?>

  <!-- MOBILE PRE-HERO CARDS (stacked, in page flow) -->
  <div class="mobile-pre-hero">
    <?php foreach ( array_slice( $prehero_posts, 0, 2 ) as $mob_post ) :
        $mob_cats  = get_the_category( $mob_post->ID );
        $mob_label = $mob_cats ? $mob_cats[0]->name : '';
        $mob_thumb = get_the_post_thumbnail_url( $mob_post->ID, 'thumbnail' );
    ?>
    <div class="mobile-pre-hero-card">
      <a href="<?php echo esc_url( get_permalink( $mob_post ) ); ?>" class="thumb">
        <?php if ( $mob_thumb ) : ?>
          <img class="ph" src="<?php echo esc_url( $mob_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $mob_post ) ); ?>" />
        <?php else : ?>
          <div class="ph ph-1"></div>
        <?php endif; ?>
      </a>
      <div class="text">
        <span class="topic-label"><?php echo esc_html( $mob_label ); ?></span>
        <a href="<?php echo esc_url( get_permalink( $mob_post ) ); ?>" class="post-title"><?php echo esc_html( get_the_title( $mob_post ) ); ?></a>
        <div class="post-author"><?php echo esc_html( get_the_author_meta( 'display_name', $mob_post->post_author ) ); ?></div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php if ( $trend_big ) :
        $mob3_cats  = get_the_category( $trend_big->ID );
        $mob3_label = $mob3_cats ? $mob3_cats[0]->name : '';
        $mob3_thumb = get_the_post_thumbnail_url( $trend_big->ID, 'thumbnail' );
    ?>
    <div class="mobile-pre-hero-card">
      <a href="<?php echo esc_url( get_permalink( $trend_big ) ); ?>" class="thumb">
        <?php if ( $mob3_thumb ) : ?>
          <img class="ph" src="<?php echo esc_url( $mob3_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $trend_big ) ); ?>" />
        <?php else : ?>
          <div class="ph ph-3"></div>
        <?php endif; ?>
      </a>
      <div class="text">
        <span class="topic-label"><?php echo esc_html( $mob3_label ); ?></span>
        <a href="<?php echo esc_url( get_permalink( $trend_big ) ); ?>" class="post-title"><?php echo esc_html( get_the_title( $trend_big ) ); ?></a>
        <div class="post-author"><?php echo esc_html( get_the_author_meta( 'display_name', $trend_big->post_author ) ); ?></div>
      </div>
    </div>
    <?php endif; ?>
  </div><!-- /mobile-pre-hero -->

  <div class="main-inner">

    <!-- Slider pagination dots -->
    <div class="slider-dots" id="slider-dots">
      <?php foreach ( $slider_posts as $dot_idx => $dot_post ) : ?>
      <button class="dot <?php echo $dot_idx === 0 ? 'active' : ''; ?>" onclick="goToSlide(<?php echo $dot_idx; ?>)"></button>
      <?php endforeach; ?>
    </div>

    <hr class="section-divider"/>

    <!-- ── TRENDING ── -->
    <?php if ( $trend_big ) : ?>
    <section class="content-section">
      <div class="section-header">
        <h2 class="section-label"><?php esc_html_e( 'Trending', 'theblotted' ); ?></h2>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="see-more"><?php esc_html_e( 'SEE MORE', 'theblotted' ); ?> &rsaquo;</a>
      </div>

      <div class="trending-grid">

        <!-- BIG CARD — col 1 -->
        <?php
        $tb_cats  = get_the_category( $trend_big->ID );
        $tb_label = $tb_cats ? $tb_cats[0]->name : '';
        $tb_thumb = get_the_post_thumbnail_url( $trend_big->ID, 'large' );
        ?>
        <article class="big-card">
          <a href="<?php echo esc_url( get_permalink( $trend_big ) ); ?>" class="card-img tall">
            <?php if ( $tb_thumb ) : ?>
              <img class="ph" src="<?php echo esc_url( $tb_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $trend_big ) ); ?>" />
            <?php else : ?>
              <div class="ph ph-dark1"></div>
            <?php endif; ?>
          </a>
          <div class="card-body">
            <div class="card-topic"><?php echo esc_html( $tb_label ); ?></div>
            <h3 class="card-title"><a href="<?php echo esc_url( get_permalink( $trend_big ) ); ?>"><?php echo esc_html( get_the_title( $trend_big ) ); ?></a></h3>
            <p class="card-desc"><?php echo theblotted_home_excerpt( $trend_big, 22 ); ?></p>
            <div class="card-meta"><?php echo esc_html( get_the_date( 'F j', $trend_big ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $trend_big->post_author ) ); ?></div>
          </div>
        </article>

        <!-- MIDDLE COL — col 2 (posts 2 & 3) -->
        <div class="stacked-col">
          <?php foreach ( $trend_mid as $tm_post ) :
              $tm_cats  = get_the_category( $tm_post->ID );
              $tm_label = $tm_cats ? $tm_cats[0]->name : '';
              $tm_thumb = get_the_post_thumbnail_url( $tm_post->ID, 'medium' );
          ?>
          <article class="small-card">
            <a href="<?php echo esc_url( get_permalink( $tm_post ) ); ?>" class="card-img medium">
              <?php if ( $tm_thumb ) : ?>
                <img class="ph" src="<?php echo esc_url( $tm_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $tm_post ) ); ?>" />
              <?php else : ?>
                <div class="ph ph-red2"></div>
              <?php endif; ?>
            </a>
            <div class="card-body">
              <div class="card-topic"><?php echo esc_html( $tm_label ); ?></div>
              <h3 class="card-title"><a href="<?php echo esc_url( get_permalink( $tm_post ) ); ?>"><?php echo esc_html( get_the_title( $tm_post ) ); ?></a></h3>
              <p class="card-desc"><?php echo theblotted_home_excerpt( $tm_post, 18 ); ?></p>
              <div class="card-meta"><?php echo esc_html( get_the_date( 'F j', $tm_post ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $tm_post->post_author ) ); ?></div>
            </div>
          </article>
          <?php endforeach; ?>
        </div>

        <!-- RIGHT COL — col 3 (posts 4 & 5) -->
        <div class="stacked-col">
          <?php foreach ( $trend_right as $tr_post ) :
              $tr_cats  = get_the_category( $tr_post->ID );
              $tr_label = $tr_cats ? $tr_cats[0]->name : '';
              $tr_thumb = get_the_post_thumbnail_url( $tr_post->ID, 'medium' );
          ?>
          <article class="small-card">
            <a href="<?php echo esc_url( get_permalink( $tr_post ) ); ?>" class="card-img medium">
              <?php if ( $tr_thumb ) : ?>
                <img class="ph" src="<?php echo esc_url( $tr_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $tr_post ) ); ?>" />
              <?php else : ?>
                <div class="ph ph-green3"></div>
              <?php endif; ?>
            </a>
            <div class="card-body">
              <div class="card-topic"><?php echo esc_html( $tr_label ); ?></div>
              <h3 class="card-title"><a href="<?php echo esc_url( get_permalink( $tr_post ) ); ?>"><?php echo esc_html( get_the_title( $tr_post ) ); ?></a></h3>
              <p class="card-desc"><?php echo theblotted_home_excerpt( $tr_post, 18 ); ?></p>
              <div class="card-meta"><?php echo esc_html( get_the_date( 'F j', $tr_post ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $tr_post->post_author ) ); ?></div>
            </div>
          </article>
          <?php endforeach; ?>
        </div>

      </div><!-- /trending-grid -->
    </section>
    <?php endif; ?>

    <hr class="section-divider"/>

    <!-- ── POPULAR ── -->
    <?php
    $popular_ids = function_exists( 'wpp_get_ids' )
        ? wpp_get_ids( [
            'limit'         => 5,
            'range'         => 'custom',
            'time_unit'     => 'day',
            'time_quantity' => 14,
            'post_type'     => 'post',
            'order_by'      => 'views',
        ] )
        : [];

    if ( ! empty( $popular_ids ) ) {
        $pop_query = new WP_Query( [
            'post_type'      => 'post',
            'post__in'       => $popular_ids,
            'orderby'        => 'post__in',
            'posts_per_page' => count( $popular_ids ),
        ] );
        $pop_posts = $pop_query->posts;
        wp_reset_postdata();
    } else {
        $pop_query = new WP_Query( [
            'posts_per_page'      => 5,
            'post__not_in'        => $rendered_post_ids,
            'ignore_sticky_posts' => 1,
            'orderby'             => 'comment_count',
            'order'               => 'DESC',
        ] );
        $pop_posts = $pop_query->posts;
        wp_reset_postdata();
    }

    $pop_hero = ! empty( $pop_posts ) ? array_shift( $pop_posts ) : null;
    $pop_quad = array_slice( $pop_posts, 0, 4 );
    if ( $pop_hero ) {
        $rendered_post_ids[] = $pop_hero->ID;
    }
    foreach ( $pop_quad as $pp ) {
        $rendered_post_ids[] = $pp->ID;
    }
    ?>
    <?php if ( $pop_hero ) : ?>
    <section class="content-section">
      <div class="section-header">
        <h2 class="section-label"><?php esc_html_e( 'Popular', 'theblotted' ); ?></h2>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="see-more"><?php esc_html_e( 'SEE MORE', 'theblotted' ); ?> &rsaquo;</a>
      </div>

      <?php
      $pop_cats  = get_the_category( $pop_hero->ID );
      $pop_label = $pop_cats ? $pop_cats[0]->name : '';
      $pop_thumb = get_the_post_thumbnail_url( $pop_hero->ID, 'full' );
      ?>
      <a href="<?php echo esc_url( get_permalink( $pop_hero ) ); ?>" class="popular-hero-card">
        <div class="card-img popular-img">
          <?php if ( $pop_thumb ) : ?>
            <img class="ph" src="<?php echo esc_url( $pop_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $pop_hero ) ); ?>" />
          <?php else : ?>
            <div class="ph ph-city"></div>
          <?php endif; ?>
        </div>
        <div class="popular-overlay">
          <div class="card-topic light"><?php echo esc_html( $pop_label ); ?></div>
          <h3 class="card-title light"><?php echo esc_html( get_the_title( $pop_hero ) ); ?></h3>
          <p class="popular-desc"><?php echo theblotted_home_excerpt( $pop_hero, 24 ); ?></p>
          <div class="card-meta light"><?php echo esc_html( get_the_date( 'F j', $pop_hero ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $pop_hero->post_author ) ); ?></div>
        </div>
      </a>

      <?php if ( ! empty( $pop_quad ) ) : ?>
      <div class="quad-grid">
        <?php foreach ( $pop_quad as $pq_post ) :
            $pq_cats  = get_the_category( $pq_post->ID );
            $pq_label = $pq_cats ? $pq_cats[0]->name : '';
            $pq_thumb = get_the_post_thumbnail_url( $pq_post->ID, 'medium' );
        ?>
        <article class="quad-card">
          <a href="<?php echo esc_url( get_permalink( $pq_post ) ); ?>" class="card-img quad-img">
            <?php if ( $pq_thumb ) : ?>
              <img class="ph" src="<?php echo esc_url( $pq_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $pq_post ) ); ?>" />
            <?php else : ?>
              <div class="ph ph-dark2"></div>
            <?php endif; ?>
          </a>
          <div class="card-body">
            <div class="card-topic"><?php echo esc_html( $pq_label ); ?></div>
            <h3 class="card-title"><a href="<?php echo esc_url( get_permalink( $pq_post ) ); ?>"><?php echo esc_html( get_the_title( $pq_post ) ); ?></a></h3>
            <p class="card-desc"><?php echo theblotted_home_excerpt( $pq_post, 18 ); ?></p>
            <div class="card-meta"><?php echo esc_html( get_the_date( 'F j', $pq_post ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $pq_post->post_author ) ); ?></div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </section>

    <hr class="section-divider"/>
    <?php endif; ?>

    <!-- ── WEEKLY ARTICLES ── -->
    <?php
    $weekly_query = new WP_Query( [
        'posts_per_page'      => 4,
        'post__not_in'        => $rendered_post_ids,
        'ignore_sticky_posts' => 1,
        'orderby'             => 'date',
        'order'               => 'DESC',
    ] );
    $weekly_posts = $weekly_query->posts;
    wp_reset_postdata();
    foreach ( $weekly_posts as $wa ) {
        $rendered_post_ids[] = $wa->ID;
    }
    ?>
    <?php if ( ! empty( $weekly_posts ) ) : ?>
    <section class="content-section">
      <div class="section-header">
        <h2 class="section-label"><?php esc_html_e( 'Weekly Articles', 'theblotted' ); ?></h2>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="see-more"><?php esc_html_e( 'SEE MORE', 'theblotted' ); ?> &rsaquo;</a>
      </div>
      <div class="quad-grid">
        <?php foreach ( $weekly_posts as $wa_post ) :
            $wa_cats  = get_the_category( $wa_post->ID );
            $wa_label = $wa_cats ? $wa_cats[0]->name : '';
            $wa_thumb = get_the_post_thumbnail_url( $wa_post->ID, 'medium' );
        ?>
        <article class="quad-card">
          <a href="<?php echo esc_url( get_permalink( $wa_post ) ); ?>" class="card-img quad-img">
            <?php if ( $wa_thumb ) : ?>
              <img class="ph" src="<?php echo esc_url( $wa_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $wa_post ) ); ?>" />
            <?php else : ?>
              <div class="ph ph-1"></div>
            <?php endif; ?>
          </a>
          <div class="card-body">
            <div class="card-topic"><?php echo esc_html( $wa_label ); ?></div>
            <h3 class="card-title"><a href="<?php echo esc_url( get_permalink( $wa_post ) ); ?>"><?php echo esc_html( get_the_title( $wa_post ) ); ?></a></h3>
            <p class="card-desc"><?php echo theblotted_home_excerpt( $wa_post, 18 ); ?></p>
            <div class="card-meta"><?php echo esc_html( get_the_date( 'F j', $wa_post ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $wa_post->post_author ) ); ?></div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

  </div><!-- /main-inner -->

  <!-- CATEGORY SECTIONS -->
  <div class="main-inner">

    <?php
    $home_sections = [
        [ 'slug' => 'issues',         'label' => 'Issues',         'count' => 4 ],
        [ 'slug' => 'literature',     'label' => 'Literature',     'count' => 4 ],
        [ 'slug' => 'pop-of-culture', 'label' => 'Pop of Culture', 'count' => 4 ],
        [ 'slug' => 'lifestyle',      'label' => 'Lifestyle',      'count' => 4 ],
        [ 'slug' => 'comedy',         'label' => 'Comedy',         'count' => 4 ],
    ];

    foreach ( $home_sections as $hs ) :
        $hs_term  = get_term_by( 'slug', $hs['slug'], 'category' );
        $hs_link  = $hs_term ? get_term_link( $hs_term ) : home_url( '/' );
        $hs_query = new WP_Query( [
            'category_name'       => $hs['slug'],
            'posts_per_page'      => $hs['count'],
            'post__not_in'        => $rendered_post_ids,
            'ignore_sticky_posts' => 1,
            'orderby'             => 'date',
            'order'               => 'DESC',
        ] );
        if ( ! $hs_query->have_posts() ) {
            wp_reset_postdata();
            continue;
        }
        $hs_posts = $hs_query->posts;
        wp_reset_postdata();
        foreach ( $hs_posts as $hp ) {
            $rendered_post_ids[] = $hp->ID;
        }
    ?>
    <hr class="section-divider"/>
    <section class="content-section">
      <div class="section-header">
        <h2 class="section-label"><?php echo esc_html( $hs['label'] ); ?></h2>
        <a href="<?php echo esc_url( $hs_link ); ?>" class="see-more"><?php esc_html_e( 'SEE MORE', 'theblotted' ); ?> &rsaquo;</a>
      </div>
      <div class="cat-grid">
        <?php foreach ( $hs_posts as $hs_post ) :
            $hs_p_cats  = get_the_category( $hs_post->ID );
            $hs_p_label = $hs_p_cats ? $hs_p_cats[0]->name : '';
            $hs_p_thumb = get_the_post_thumbnail_url( $hs_post->ID, 'medium' );
        ?>
        <article class="cat-card">
          <a href="<?php echo esc_url( get_permalink( $hs_post ) ); ?>" class="cat-img">
            <?php if ( $hs_p_thumb ) : ?>
              <img class="ph" src="<?php echo esc_url( $hs_p_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $hs_post ) ); ?>" />
            <?php else : ?>
              <div class="ph ph-dark1"></div>
            <?php endif; ?>
          </a>
          <div class="card-body">
            <div class="card-topic"><?php echo esc_html( $hs_p_label ); ?></div>
            <h3 class="card-title"><a href="<?php echo esc_url( get_permalink( $hs_post ) ); ?>"><?php echo esc_html( get_the_title( $hs_post ) ); ?></a></h3>
            <p class="card-desc"><?php echo theblotted_home_excerpt( $hs_post, 20 ); ?></p>
            <div class="card-meta"><?php echo esc_html( get_the_date( 'F j', $hs_post ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $hs_post->post_author ) ); ?></div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endforeach; ?>

    <!-- ── CARTOONS & CROSSWORDS ── -->
    <?php
    $cc_query = new WP_Query( [
        'posts_per_page'      => 3,
        'post__not_in'        => $rendered_post_ids,
        'ignore_sticky_posts' => 1,
        'orderby'             => 'date',
        'order'               => 'DESC',
        'tax_query'           => [ [
            'relation' => 'OR',
            [ 'taxonomy' => 'category', 'field' => 'slug', 'terms' => 'cartoons' ],
            [ 'taxonomy' => 'category', 'field' => 'slug', 'terms' => 'crosswords' ],
            [ 'taxonomy' => 'category', 'field' => 'slug', 'terms' => 'cartoons-crosswords' ],
        ] ],
    ] );
    $cc_posts = $cc_query->posts;
    wp_reset_postdata();

    $cc_term  = get_term_by( 'slug', 'cartoons-crosswords', 'category' ) ?: get_term_by( 'slug', 'cartoons', 'category' );
    $cc_link  = $cc_term ? get_term_link( $cc_term ) : home_url( '/' );
    $cc_big   = ! empty( $cc_posts ) ? $cc_posts[0] : null;
    $cc_right = array_slice( $cc_posts, 1, 2 );
    ?>
    <?php if ( $cc_big ) : ?>
    <hr class="section-divider"/>
    <section class="content-section">
      <div class="section-header">
        <h2 class="section-label"><?php esc_html_e( 'Cartoons &amp; Crosswords', 'theblotted' ); ?></h2>
        <a href="<?php echo esc_url( $cc_link ); ?>" class="see-more"><?php esc_html_e( 'SEE MORE', 'theblotted' ); ?> &rsaquo;</a>
      </div>

      <div class="cc-grid">
        <?php
        $ccb_cats  = get_the_category( $cc_big->ID );
        $ccb_label = $ccb_cats ? $ccb_cats[0]->name : '';
        $ccb_thumb = get_the_post_thumbnail_url( $cc_big->ID, 'large' );
        ?>
        <article class="cc-big">
          <a href="<?php echo esc_url( get_permalink( $cc_big ) ); ?>" class="cc-big-img">
            <?php if ( $ccb_thumb ) : ?>
              <img class="ph" src="<?php echo esc_url( $ccb_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $cc_big ) ); ?>" />
            <?php else : ?>
              <div class="ph ph-dark1"></div>
            <?php endif; ?>
          </a>
          <div class="card-body">
            <div class="card-topic"><?php echo esc_html( $ccb_label ); ?></div>
            <h3 class="card-title"><a href="<?php echo esc_url( get_permalink( $cc_big ) ); ?>"><?php echo esc_html( get_the_title( $cc_big ) ); ?></a></h3>
            <p class="card-desc"><?php echo theblotted_home_excerpt( $cc_big, 20 ); ?></p>
            <div class="card-meta"><?php echo esc_html( get_the_date( 'F j', $cc_big ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $cc_big->post_author ) ); ?></div>
          </div>
        </article>

        <?php if ( ! empty( $cc_right ) ) : ?>
        <div class="cc-right">
          <?php foreach ( $cc_right as $cc_r ) :
              $ccr_cats  = get_the_category( $cc_r->ID );
              $ccr_label = $ccr_cats ? $ccr_cats[0]->name : '';
              $ccr_thumb = get_the_post_thumbnail_url( $cc_r->ID, 'medium' );
          ?>
          <article class="cc-card">
            <a href="<?php echo esc_url( get_permalink( $cc_r ) ); ?>" class="cc-img">
              <?php if ( $ccr_thumb ) : ?>
                <img class="ph" src="<?php echo esc_url( $ccr_thumb ); ?>" alt="<?php echo esc_attr( get_the_title( $cc_r ) ); ?>" />
              <?php else : ?>
                <div class="ph ph-2"></div>
              <?php endif; ?>
            </a>
            <div class="card-body">
              <div class="card-topic"><?php echo esc_html( $ccr_label ); ?></div>
              <h3 class="card-title"><a href="<?php echo esc_url( get_permalink( $cc_r ) ); ?>"><?php echo esc_html( get_the_title( $cc_r ) ); ?></a></h3>
              <p class="card-desc"><?php echo theblotted_home_excerpt( $cc_r, 15 ); ?></p>
              <div class="card-meta"><?php echo esc_html( get_the_date( 'F j', $cc_r ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $cc_r->post_author ) ); ?></div>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

      </div><!-- /cc-grid -->
    </section>
    <?php endif; ?>

  </div><!-- /category sections inner -->

</main><!-- /#main-content -->

<!-- Newsletter -->
<div class="newsletter-banner">
  <p><?php esc_html_e( 'Subscribe to our newsletter to get weekly updates to your inbox.', 'theblotted' ); ?></p>
  <div class="newsletter-form">
    <form action="#" method="post">
      <?php wp_nonce_field( 'theblotted_newsletter', 'newsletter_nonce' ); ?>
      <input type="email" name="newsletter-email" autocomplete="email"
             placeholder="<?php esc_attr_e( 'Email', 'theblotted' ); ?>"
             aria-label="<?php esc_attr_e( 'Email address', 'theblotted' ); ?>"
             required />
      <button type="submit"><?php esc_html_e( 'Subscribe', 'theblotted' ); ?></button>
    </form>
  </div>
</div>
