<?php
/* Template part for Lifestyle page */

/**
 * Template part for the Lifestyle category page.
 * Based on theblotted-category.html structure.
 *
 * @package theblotted
 */

$cat_slug  = 'lifestyle';
$cat_label = 'Lifestyle';

$cat_term = get_term_by( 'slug', $cat_slug, 'category' );
$cat_link = $cat_term ? get_term_link( $cat_term ) : home_url( '/' );

// Featured posts (5 total)
$featured_query = new WP_Query( [
  'category_name'       => $cat_slug,
  'posts_per_page'      => 5,
  'ignore_sticky_posts' => 1,
  'orderby'             => 'date',
  'order'               => 'DESC',
] );
$featured_posts = $featured_query->posts;
wp_reset_postdata();

$feat_big  = isset( $featured_posts[0] ) ? $featured_posts[0] : null;
$feat_side = array_slice( $featured_posts, 1, 4 ); // 4 side cards

// Grid posts (12 more, excluding featured)
$featured_ids = wp_list_pluck( $featured_posts, 'ID' );
$grid_query = new WP_Query( [
  'category_name'       => $cat_slug,
  'posts_per_page'      => 12,
  'post__not_in'        => $featured_ids,
  'ignore_sticky_posts' => 1,
  'orderby'             => 'date',
  'order'               => 'DESC',
] );
$grid_posts = $grid_query->posts;
wp_reset_postdata();

// Mobile recent posts (4) and explore posts (6)
$mob_recent  = array_slice( $featured_posts, 0, 4 );
$mob_explore = array_slice( $grid_posts, 0, 6 );
?>

<div class="page-wrap">

  <!-- "RECENT" label — mobile only -->
  <div class="mob-label mob-label-recent-desk"><?php esc_html_e( 'Recent', 'theblotted' ); ?></div>

  <!-- ── FEATURED BLOCK ── -->
  <div class="featured-grid">

    <!-- Big left card -->
    <?php if ( $feat_big ) : ?>
    <article class="feat-big">
      <a href="<?php echo esc_url( get_permalink( $feat_big ) ); ?>">
        <?php if ( has_post_thumbnail( $feat_big ) ) : ?>
          <div class="feat-big-img">
            <?php echo get_the_post_thumbnail( $feat_big, 'large', [ 'alt' => esc_attr( get_the_title( $feat_big ) ) ] ); ?>
          </div>
        <?php else : ?>
          <div class="feat-big-img ph-1"></div>
        <?php endif; ?>
      </a>
      <h2 class="t">
        <a href="<?php echo esc_url( get_permalink( $feat_big ) ); ?>"><?php echo esc_html( get_the_title( $feat_big ) ); ?></a>
      </h2>
      <p class="d"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $feat_big ) ), 20, '…' ) ); ?></p>
      <div class="m"><?php echo esc_html( get_the_date( 'F j', $feat_big ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $feat_big->post_author ) ); ?></div>
    </article>
    <?php endif; ?>

    <!-- Mid col (side cards 1 & 2) -->
    <div class="feat-col">
      <?php foreach ( array_slice( $feat_side, 0, 2 ) as $sc ) : ?>
      <article class="feat-card">
        <a href="<?php echo esc_url( get_permalink( $sc ) ); ?>">
          <?php if ( has_post_thumbnail( $sc ) ) : ?>
            <div class="feat-img">
              <?php echo get_the_post_thumbnail( $sc, 'medium', [ 'alt' => esc_attr( get_the_title( $sc ) ) ] ); ?>
            </div>
          <?php else : ?>
            <div class="feat-img ph-2"></div>
          <?php endif; ?>
        </a>
        <h3 class="t">
          <a href="<?php echo esc_url( get_permalink( $sc ) ); ?>"><?php echo esc_html( get_the_title( $sc ) ); ?></a>
        </h3>
        <p class="d"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $sc ) ), 18, '…' ) ); ?></p>
        <div class="m"><?php echo esc_html( get_the_date( 'F j', $sc ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $sc->post_author ) ); ?></div>
      </article>
      <?php endforeach; ?>
    </div>

    <!-- Right col (side cards 3 & 4) -->
    <div class="feat-col">
      <?php foreach ( array_slice( $feat_side, 2, 2 ) as $sc ) : ?>
      <article class="feat-card">
        <a href="<?php echo esc_url( get_permalink( $sc ) ); ?>">
          <?php if ( has_post_thumbnail( $sc ) ) : ?>
            <div class="feat-img">
              <?php echo get_the_post_thumbnail( $sc, 'medium', [ 'alt' => esc_attr( get_the_title( $sc ) ) ] ); ?>
            </div>
          <?php else : ?>
            <div class="feat-img ph-4"></div>
          <?php endif; ?>
        </a>
        <h3 class="t">
          <a href="<?php echo esc_url( get_permalink( $sc ) ); ?>"><?php echo esc_html( get_the_title( $sc ) ); ?></a>
        </h3>
        <p class="d"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $sc ) ), 18, '…' ) ); ?></p>
        <div class="m"><?php echo esc_html( get_the_date( 'F j', $sc ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $sc->post_author ) ); ?></div>
      </article>
      <?php endforeach; ?>
    </div>

  </div><!-- /featured-grid -->

  <hr class="divider desk-divider"/>

  <!-- "EXPLORE" label — mobile only -->
  <div class="mob-label mob-label-recent-desk" style="margin-top:24px;"><?php esc_html_e( 'Explore', 'theblotted' ); ?></div>

  <!-- ── ARTICLE GRID ── -->
  <?php if ( ! empty( $grid_posts ) ) : ?>
  <div class="art-grid">
    <?php foreach ( $grid_posts as $gp ) : ?>
    <article class="art-card">
      <a href="<?php echo esc_url( get_permalink( $gp ) ); ?>">
        <?php if ( has_post_thumbnail( $gp ) ) : ?>
          <div class="art-img">
            <?php echo get_the_post_thumbnail( $gp, 'medium', [ 'alt' => esc_attr( get_the_title( $gp ) ) ] ); ?>
          </div>
        <?php else : ?>
          <div class="art-img ph-6"></div>
        <?php endif; ?>
      </a>
      <h3 class="t">
        <a href="<?php echo esc_url( get_permalink( $gp ) ); ?>"><?php echo esc_html( get_the_title( $gp ) ); ?></a>
      </h3>
      <p class="d"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $gp ) ), 20, '…' ) ); ?></p>
      <div class="m"><?php echo esc_html( get_the_date( 'F j', $gp ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $gp->post_author ) ); ?></div>
    </article>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <?php
  $total_cat_posts = $cat_term ? $cat_term->count : 0;
  $shown_posts = count( $featured_posts ) + count( $grid_posts );
  if ( $total_cat_posts > $shown_posts ) :
  ?>
  <div class="load-more"><a href="<?php echo esc_url( $cat_link ); ?>"><button><?php esc_html_e( 'Load more', 'theblotted' ); ?></button></a></div>
  <?php endif; ?>

  <!-- ══ MOBILE RECENT — 4 full-width stacked cards ══ -->
  <div class="mob-recent">
    <?php foreach ( $mob_recent as $mr ) : ?>
    <article class="mob-recent-card">
      <a href="<?php echo esc_url( get_permalink( $mr ) ); ?>">
        <?php if ( has_post_thumbnail( $mr ) ) : ?>
          <div class="mob-recent-img">
            <?php echo get_the_post_thumbnail( $mr, 'medium', [ 'alt' => esc_attr( get_the_title( $mr ) ) ] ); ?>
          </div>
        <?php else : ?>
          <div class="mob-recent-img ph-1"></div>
        <?php endif; ?>
      </a>
      <h2 class="t">
        <a href="<?php echo esc_url( get_permalink( $mr ) ); ?>"><?php echo esc_html( get_the_title( $mr ) ); ?></a>
      </h2>
      <p class="d"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $mr ) ), 20, '…' ) ); ?></p>
      <div class="m"><?php echo esc_html( get_the_date( 'F j', $mr ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $mr->post_author ) ); ?></div>
    </article>
    <?php endforeach; ?>
  </div>

  <!-- EXPLORE label — mobile only -->
  <div class="mob-label" id="mob-explore-label" style="display:none; padding-top:20px; border-top:1px solid var(--color-divider); margin-top:4px;"><?php esc_html_e( 'Explore', 'theblotted' ); ?></div>

  <!-- ══ MOBILE EXPLORE — horizontal thumb + text ══ -->
  <div class="mob-explore">
    <?php foreach ( $mob_explore as $idx => $me ) : ?>
    <?php if ( $idx === 3 ) : ?>
    <div class="mob-ad"><?php esc_html_e( 'AD SPACE', 'theblotted' ); ?></div>
    <?php endif; ?>
    <article class="mob-explore-card">
      <a href="<?php echo esc_url( get_permalink( $me ) ); ?>">
        <?php if ( has_post_thumbnail( $me ) ) : ?>
          <div class="mob-explore-thumb">
            <?php echo get_the_post_thumbnail( $me, 'thumbnail', [ 'alt' => esc_attr( get_the_title( $me ) ) ] ); ?>
          </div>
        <?php else : ?>
          <div class="mob-explore-thumb ph-5"></div>
        <?php endif; ?>
      </a>
      <div class="mob-explore-text">
        <h3 class="t">
          <a href="<?php echo esc_url( get_permalink( $me ) ); ?>"><?php echo esc_html( get_the_title( $me ) ); ?></a>
        </h3>
        <p class="d"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $me ) ), 15, '…' ) ); ?></p>
        <div class="m"><?php echo esc_html( get_the_date( 'F j', $me ) ); ?> &nbsp;|&nbsp; <?php echo esc_html( get_the_author_meta( 'display_name', $me->post_author ) ); ?></div>
      </div>
    </article>
    <?php endforeach; ?>
  </div>

  <div class="mob-ad"><?php esc_html_e( 'AD SPACE', 'theblotted' ); ?></div>
  <div class="mob-load-more"><a href="<?php echo esc_url( $cat_link ); ?>"><button><?php esc_html_e( 'Load more', 'theblotted' ); ?></button></a></div>

</div><!-- /page-wrap -->

<!-- NEWSLETTER -->
<div class="newsletter">
  <p><?php esc_html_e( 'Subscribe to our newsletter to get weekly updates to your inbox.', 'theblotted' ); ?></p>
  <div class="nl-form">
    <form action="#" method="post">
      <?php wp_nonce_field( 'theblotted_newsletter', 'newsletter_nonce' ); ?>
      <input type="email" name="newsletter-email" autocomplete="email" placeholder="<?php esc_attr_e( 'Email', 'theblotted' ); ?>" required />
      <button type="submit"><?php esc_html_e( 'Subscribe', 'theblotted' ); ?></button>
    </form>
  </div>
</div>
