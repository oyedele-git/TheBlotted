<?php
/* Template part for single post / article page */

/**
 * Template part for a single Post.
 * Based on theblotted-article.html structure.
 *
 * @package theblotted
 */

// Post meta
$categories   = get_the_category();
$cat          = $categories ? $categories[0] : null;
$cat_label    = $cat ? $cat->name : '';
$cat_link     = $cat ? get_term_link( $cat ) : home_url( '/' );
$post_date    = get_the_date( 'F j, Y' );
$author_id    = get_the_author_meta( 'ID' );
$author_name  = get_the_author();
$author_bio   = get_the_author_meta( 'description' );

// ACF fields
$article_type     = function_exists( 'get_field' ) ? get_field( 'article_type' )      : '';
$article_subtitle = function_exists( 'get_field' ) ? get_field( 'article_subtitle' )  : '';
$mid_article_img  = function_exists( 'get_field' ) ? get_field( 'mid_article_image' ) : null;

// Use article_type ACF field to override the category label if set
$topic_label = ! empty( $article_type ) ? $article_type : $cat_label;

// Share URLs
$share_url    = urlencode( get_permalink() );
$share_title  = urlencode( get_the_title() );
$twitter_url  = 'https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_title;
$fb_url       = 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url;

// Sidebar ad
$ads_img = function_exists( 'theblotted_acf_img_url' )
  ? theblotted_acf_img_url(
      'global_sidebar_ad',
      theblotted_get_settings_page_id(),
      esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/Frame 46.png' )
    )
  : '';

// Related posts from same category (4 from same category, random order)
$related_posts = [];
if ( $categories ) {
  $cat_ids = wp_list_pluck( $categories, 'term_id' );
  $related_query = new WP_Query( [
    'category__in'        => $cat_ids,
    'post__not_in'        => [ get_the_ID() ],
    'posts_per_page'      => 4,
    'ignore_sticky_posts' => 1,
    'orderby'             => 'rand',
  ] );
  $related_posts = $related_query->posts;
  wp_reset_postdata();
}
?>

<!-- ═══════════════════════════════════════════════════
     ARTICLE HERO IMAGE
══════════════════════════════════════════════════════ -->
<?php if ( has_post_thumbnail() ) : ?>
<div class="article-hero">
  <?php the_post_thumbnail( 'full', [ 'class' => 'article-hero-img' ] ); ?>
</div>
<?php else : ?>
<div class="article-hero ph-hero"></div>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════
     ARTICLE CONTENT
══════════════════════════════════════════════════════ -->
<div class="article-wrap">

  <!-- Article header -->
  <header class="article-header">
    <div class="article-category">
      <?php if ( $cat ) : ?>
        <a href="<?php echo esc_url( $cat_link ); ?>"><?php echo esc_html( $topic_label ); ?></a>
      <?php else : ?>
        <?php echo esc_html( $topic_label ); ?>
      <?php endif; ?>
    </div>
    <h1 class="article-title"><?php the_title(); ?></h1>
    <?php if ( $article_subtitle ) : ?>
    <p class="article-subtitle"><?php echo esc_html( $article_subtitle ); ?></p>
    <?php endif; ?>
    <div class="article-meta-row">
      <div class="article-author-thumb">
        <?php echo get_avatar( $author_id, 40, '', esc_attr( $author_name ), [ 'class' => 'article-author-avatar' ] ); ?>
      </div>
      <div class="article-author-info">
        <span class="article-author-name"><?php echo esc_html( $author_name ); ?></span>
        <span class="article-date"><?php echo esc_html( $post_date ); ?></span>
      </div>
      <!-- Top share buttons -->
      <div class="article-share-row">
        <span class="share-label"><?php esc_html_e( 'Share', 'theblotted' ); ?></span>
        <!-- X / Twitter -->
        <a href="<?php echo esc_url( $twitter_url ); ?>" class="share-btn" aria-label="<?php esc_attr_e( 'Share on X', 'theblotted' ); ?>" target="_blank" rel="noopener noreferrer">
          <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.259 5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <!-- Facebook -->
        <a href="<?php echo esc_url( $fb_url ); ?>" class="share-btn" aria-label="<?php esc_attr_e( 'Share on Facebook', 'theblotted' ); ?>" target="_blank" rel="noopener noreferrer">
          <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
        <!-- Instagram -->
        <a href="#" class="share-btn" aria-label="<?php esc_attr_e( 'Share on Instagram', 'theblotted' ); ?>">
          <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        </a>
        <!-- Copy link -->
        <a href="<?php echo esc_url( get_permalink() ); ?>" class="share-btn" aria-label="<?php esc_attr_e( 'Copy link', 'theblotted' ); ?>" onclick="theblottedCopyLink(event)">
          <svg viewBox="0 0 24 24" fill="white"><path d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
        </a>
      </div>
    </div>
  </header>

  <!-- Article body -->
  <article class="article-body">
    <?php the_content(); ?>

    <?php if ( $mid_article_img ) : ?>
    <div class="article-inline-img">
      <img src="<?php echo esc_url( $mid_article_img['url'] ); ?>" alt="<?php echo esc_attr( $mid_article_img['alt'] ); ?>" />
    </div>
    <?php if ( ! empty( $mid_article_img['caption'] ) ) : ?>
    <p class="img-caption"><?php echo esc_html( $mid_article_img['caption'] ); ?></p>
    <?php endif; ?>
    <?php endif; ?>
  </article>

  <!-- Bottom share bar -->
  <div class="article-share-bar">
    <span class="share-label"><?php esc_html_e( 'Share this article', 'theblotted' ); ?></span>
    <a href="<?php echo esc_url( $twitter_url ); ?>" class="share-btn-pill" target="_blank" rel="noopener noreferrer">
      <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.259 5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
      <?php esc_html_e( 'X / Twitter', 'theblotted' ); ?>
    </a>
    <a href="<?php echo esc_url( $fb_url ); ?>" class="share-btn-pill" target="_blank" rel="noopener noreferrer">
      <svg viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
      <?php esc_html_e( 'Facebook', 'theblotted' ); ?>
    </a>
    <button class="share-btn-pill" onclick="theblottedCopyLink(event)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244"/></svg>
      <?php esc_html_e( 'Copy Link', 'theblotted' ); ?>
    </button>
  </div>

  <!-- Author bio -->
  <?php if ( $author_bio ) : ?>
  <div class="author-bio">
    <div class="author-bio-thumb">
      <?php echo get_avatar( $author_id, 80, '', esc_attr( $author_name ), [ 'class' => 'author-bio-avatar' ] ); ?>
    </div>
    <div class="author-bio-content">
      <span class="author-bio-label"><?php esc_html_e( 'Written by', 'theblotted' ); ?></span>
      <div class="author-bio-name"><?php echo esc_html( $author_name ); ?></div>
      <p class="author-bio-text"><?php echo esc_html( $author_bio ); ?></p>
      <div class="author-bio-social">
        <?php
        $author_twitter   = get_the_author_meta( 'twitter', $author_id );
        $author_instagram = get_the_author_meta( 'instagram', $author_id );
        if ( $author_twitter ) :
        ?>
        <a href="<?php echo esc_url( 'https://twitter.com/' . $author_twitter ); ?>" aria-label="<?php esc_attr_e( 'X', 'theblotted' ); ?>" target="_blank" rel="noopener noreferrer">
          <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.259 5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <?php endif; ?>
        <?php if ( $author_instagram ) : ?>
        <a href="<?php echo esc_url( 'https://instagram.com/' . $author_instagram ); ?>" aria-label="<?php esc_attr_e( 'Instagram', 'theblotted' ); ?>" target="_blank" rel="noopener noreferrer">
          <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
        </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Comments section -->
  <?php if ( comments_open() || get_comments_number() ) : ?>
  <div class="comments-section">
    <?php comments_template(); ?>
  </div>
  <?php endif; ?>

  <!-- Related articles -->
  <?php if ( ! empty( $related_posts ) ) : ?>
  <div class="related-section">
    <div class="related-header">
      <span class="related-label"><?php esc_html_e( 'You Might Also Like', 'theblotted' ); ?></span>
      <?php if ( $cat ) : ?>
      <a href="<?php echo esc_url( $cat_link ); ?>" class="see-more"><?php esc_html_e( 'See More', 'theblotted' ); ?> &rsaquo;</a>
      <?php endif; ?>
    </div>
    <div class="related-grid">
      <?php foreach ( $related_posts as $rp ) :
        $rp_cats  = get_the_category( $rp->ID );
        $rp_cat   = $rp_cats ? $rp_cats[0]->name : '';
        $rp_date  = get_the_date( 'F j', $rp );
        $rp_author = get_the_author_meta( 'display_name', $rp->post_author );
      ?>
      <article class="related-card">
        <?php if ( has_post_thumbnail( $rp ) ) : ?>
        <a href="<?php echo esc_url( get_permalink( $rp ) ); ?>">
          <?php echo get_the_post_thumbnail( $rp, 'medium', [ 'class' => 'related-img', 'alt' => esc_attr( get_the_title( $rp ) ) ] ); ?>
        </a>
        <?php else : ?>
        <div class="related-img"></div>
        <?php endif; ?>
        <?php if ( $rp_cat ) : ?>
        <div class="related-topic"><?php echo esc_html( $rp_cat ); ?></div>
        <?php endif; ?>
        <h3 class="related-title">
          <a href="<?php echo esc_url( get_permalink( $rp ) ); ?>"><?php echo esc_html( get_the_title( $rp ) ); ?></a>
        </h3>
        <div class="related-meta"><?php echo esc_html( $rp_date ); ?> &nbsp;|&nbsp; <?php echo esc_html( $rp_author ); ?></div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>

</div><!-- /article-wrap -->

<!-- Newsletter -->
<div class="newsletter-banner">
  <p><?php esc_html_e( 'Subscribe to our newsletter to get weekly updates to your inbox.', 'theblotted' ); ?></p>
  <div class="newsletter-form">
    <form action="#" method="post">
      <?php wp_nonce_field( 'theblotted_newsletter', 'newsletter_nonce' ); ?>
      <input type="email" name="newsletter-email" autocomplete="email" placeholder="<?php esc_attr_e( 'Email', 'theblotted' ); ?>" aria-label="<?php esc_attr_e( 'Email address', 'theblotted' ); ?>" required />
      <button type="submit"><?php esc_html_e( 'Subscribe', 'theblotted' ); ?></button>
    </form>
  </div>
</div>

<script>
function theblottedCopyLink(e) {
  e.preventDefault();
  if ( navigator.clipboard ) {
    navigator.clipboard.writeText(window.location.href).then(function() {
      var btn = e.currentTarget;
      var original = btn.innerHTML;
      btn.innerHTML = btn.tagName === 'BUTTON'
        ? btn.innerHTML.replace(/Copy Link/, 'Copied!')
        : '✓';
      setTimeout(function() { btn.innerHTML = original; }, 2000);
    });
  }
}
</script>
