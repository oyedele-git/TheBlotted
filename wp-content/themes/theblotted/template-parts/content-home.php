<?php

/**
 * Template part for Homepage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */
?>

<main>
  <div class="app-wrapper">
    <!-- desktop here -->
    <section class="hero-section">
      <div style="display: flex; flex-direction: column; width: 100%">
        <div class="topic-section">
          <div class="topic-container">
            <?php
            $sticky_posts = get_option('sticky_posts');
            $rendered_post_ids = [];
            $topic_query = new WP_Query(
                [
                'post__not_in' => $sticky_posts,
                'posts_per_page' => 2,
                'ignore_sticky_posts' => 1,
                'orderby' => 'date',
                'order' => 'DESC',
                ]
            );
            ?>

            <?php if ($topic_query->have_posts()) : ?>
                <?php while ($topic_query->have_posts()) : $topic_query->the_post(); ?>
                    <?php
                    $rendered_post_ids[] = get_the_ID();
                    $categories = get_the_category();
                    $topic_label = $categories ? $categories[0]->name : '';
                    ?>
                <div class="topic-cards">
                  <div class="card-image">
                    <?php if (has_post_thumbnail()) : ?>
                      <a href="<?php echo esc_url(get_permalink()); ?>">
                        <?php the_post_thumbnail('medium', ['alt' => esc_attr(get_the_title())]); ?>
                      </a>
                    <?php endif; ?>
                  </div>
                  <div class="text-box">
                    <p class="card-topic"><?php echo esc_html($topic_label); ?></p>
                    <h2 class="card-title">
                      <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
                    </h2>
                    <span class="card-author"><?php echo esc_html(get_the_author()); ?></span>
                  </div>
                </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>

            <div class="topic-cards no-gap">
              <div class="card-image" style="max-width: 100%">
                <img src="image/image4.jpg" alt="card-image" />
              </div>
              <div class="text-box">
                <p class="card-topic"></p>
                <h2 class="card-title"></h2>
                <span class="card-author"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="top" class="wrap">
        <div class="home swiper">
          <div class="swiper-wrapper">
            <?php
            $sticky_posts = get_option('sticky_posts');
            $sticky_query = new WP_Query(
                [
                'post__in' => $sticky_posts,
                'posts_per_page' => 3,
                'ignore_sticky_posts' => 1,
                'orderby' => 'date',
                'order' => 'DESC',
                ]
            );
            ?>

            <?php if ($sticky_query->have_posts()) : ?>
                <?php while ($sticky_query->have_posts()) : $sticky_query->the_post(); ?>
                    <?php $rendered_post_ids[] = get_the_ID(); ?>
                <div class="swiper-slide">
                  <a class="slide-link" href="<?php echo esc_url(get_permalink()); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('full', ['class' => 'slide-bg', 'alt' => esc_attr(get_the_title())]); ?>
                    <?php endif; ?>
                    <div class="overlay"></div>
                    <div class="content">
                      <h1><?php the_title(); ?></h1>
                      <p>
                        <?php
                        $excerpt_source = get_the_excerpt();
                        if ($excerpt_source === '') {
                            $excerpt_source = get_the_content();
                        }
                        echo esc_html(wp_trim_words(wp_strip_all_tags($excerpt_source), 15, '…'));
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
        <a href="article.html">
          <h3>SEE MORE</h3>
          <img src="image/next-link.png" alt="" />
        </a>
      </div>
      <div class="trend-cards">
        <?php
        $new_query = new WP_Query(
            [
            'post__not_in' => $rendered_post_ids,
            'posts_per_page' => 5,
            'ignore_sticky_posts' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            ]
        );
        $new_posts = $new_query->posts;
        ?>
        <?php if (!empty($new_posts)) : ?>
            <?php
            $primary_post = array_shift($new_posts);
            $left_posts = array_slice($new_posts, 0, 2);
            $right_posts = array_slice($new_posts, 2, 2);
            ?>
          <div class="first-card">
            <div class="card-container">
              <div class="card-img">
                <?php if (has_post_thumbnail($primary_post)) : ?>
                  <a href="<?php echo esc_url(get_permalink($primary_post)); ?>">
                    <?php echo get_the_post_thumbnail($primary_post, 'large', ['alt' => esc_attr(get_the_title($primary_post))]); ?>
                  </a>
                <?php endif; ?>
              </div>
              <div class="text-container">
                <h2 class="title">
                  <a href="<?php echo esc_url(get_permalink($primary_post)); ?>">
                    <?php echo esc_html(get_the_title($primary_post)); ?>
                  </a>
                </h2>
                <p class="discription">
                  <?php
                    $excerpt_source = get_the_excerpt($primary_post);
                    if ($excerpt_source === '') {
                        $excerpt_source = get_the_content(null, false, $primary_post);
                    }
                    echo esc_html(wp_trim_words(wp_strip_all_tags($excerpt_source), 25, '…'));
                    ?>
                </p>

                <span class="author">
                  <?php echo esc_html(get_the_date('F j', $primary_post)); ?> | <?php echo esc_html(get_the_author_meta('display_name', $primary_post->post_author)); ?>
                </span>
              </div>
            </div>
          </div>
          <div class="second-card">
            <div>
              <?php foreach ($left_posts as $index => $post) : ?>
                <div class="card-container <?php echo $index === 0 ? 'card-1' : 'card-2'; ?>">
                  <div class="card-img">
                    <?php if (has_post_thumbnail($post)) : ?>
                      <a href="<?php echo esc_url(get_permalink($post)); ?>">
                        <?php echo get_the_post_thumbnail($post, 'medium', ['alt' => esc_attr(get_the_title($post))]); ?>
                      </a>
                    <?php endif; ?>
                  </div>
                  <div class="text-container">
                    <h2 class="title">
                      <a href="<?php echo esc_url(get_permalink($post)); ?>">
                        <?php echo esc_html(get_the_title($post)); ?>
                      </a>
                    </h2>
                    <p class="discription">
                      <?php
                        $excerpt_source = get_the_excerpt($post);
                        if ($excerpt_source === '') {
                            $excerpt_source = get_the_content(null, false, $post);
                        }
                        echo esc_html(wp_trim_words(wp_strip_all_tags($excerpt_source), 18, '…'));
                        ?>
                    </p>

                    <span class="author">
                      <?php echo esc_html(get_the_date('F j', $post)); ?> | <?php echo esc_html(get_the_author_meta('display_name', $post->post_author)); ?>
                    </span>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <div>
              <?php foreach ($right_posts as $index => $post) : ?>
                <div class="card-container <?php echo $index === 0 ? 'card-1' : 'card-2'; ?>">
                  <div class="card-img">
                    <?php if (has_post_thumbnail($post)) : ?>
                      <a href="<?php echo esc_url(get_permalink($post)); ?>">
                        <?php echo get_the_post_thumbnail($post, 'medium', ['alt' => esc_attr(get_the_title($post))]); ?>
                      </a>
                    <?php endif; ?>
                  </div>
                  <div class="text-container">
                    <h2 class="title">
                      <a href="<?php echo esc_url(get_permalink($post)); ?>">
                        <?php echo esc_html(get_the_title($post)); ?>
                      </a>
                    </h2>
                    <p class="discription">
                      <?php
                        $excerpt_source = get_the_excerpt($post);
                        if ($excerpt_source === '') {
                            $excerpt_source = get_the_content(null, false, $post);
                        }
                        echo esc_html(wp_trim_words(wp_strip_all_tags($excerpt_source), 18, '…'));
                        ?>
                    </p>

                    <span class="author">
                      <?php echo esc_html(get_the_date('F j', $post)); ?> | <?php echo esc_html(get_the_author_meta('display_name', $post->post_author)); ?>
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
        <a href="article.html">
          <h3>SEE MORE</h3>
          <img src="image/next-link.png" alt="" />
        </a>
      </div>
      <?php
        $popular_ids = function_exists('wpp_get_ids')
        ? wpp_get_ids(
            [
            'limit' => 5,
            'range' => 'custom',
            'time_unit' => 'day',
            'time_quantity' => 14,
            'post_type' => 'post',
            'order_by' => 'views'
            ]
        )
        : [];
        $popular_posts = [];

        if (!empty($popular_ids)) {
            $popular_query = new WP_Query(
                [
                'post_type' => 'post',
                'post__in' => $popular_ids,
                'orderby' => 'post__in',
                'posts_per_page' => count($popular_ids)
                ]
            );
            $popular_posts = $popular_query->posts;
            wp_reset_postdata();
        }

        $popular_hero = !empty($popular_posts) ? array_shift($popular_posts) : null;
        $popular_default_hero = get_template_directory_uri() . '/image/background.png';
        $popular_default_thumb = get_template_directory_uri() . '/image/image 12.png';
        ?>
      <?php if ($popular_hero) : ?>
            <?php
            $hero_image = get_the_post_thumbnail_url($popular_hero, 'full');
            $hero_image = $hero_image ? $hero_image : $popular_default_hero;
            $hero_categories = get_the_category($popular_hero->ID);
            $hero_category = !empty($hero_categories) ? $hero_categories[0]->name : 'Popular';
            $hero_excerpt = get_the_excerpt($popular_hero);
            if ($hero_excerpt === '') {
                $hero_excerpt = get_the_content(null, false, $popular_hero);
            }
            ?>
        <a class="popular-hero-link" href="<?php echo esc_url(get_permalink($popular_hero)); ?>">
          <div
            class="image-background"
            style="
                  background-image: linear-gradient(
                      1.76deg,
                      #251d14 1.49%,
                      rgba(37, 29, 20, 0) 99.95%
                    ),
                    url('<?php echo esc_url($hero_image); ?>');
                  background-size: cover;
                  background-position: center;
                ">
            <div class="text-container">
              <span class="author"><?php echo esc_html($hero_category); ?></span>
              <h2 class="title">
                <span><?php echo esc_html(get_the_title($popular_hero)); ?></span>
              </h2>
              <p class="discription">
                <?php echo esc_html(wp_trim_words(wp_strip_all_tags($hero_excerpt), 24, '…')); ?>
              </p>

              <span class="author"><?php echo esc_html(get_the_date('F j', $popular_hero)); ?> | <?php echo esc_html(get_the_author_meta('display_name', $popular_hero->post_author)); ?></span>
            </div>
          </div>
        </a>
      <?php endif; ?>
      <?php if (!empty($popular_posts)) : ?>
        <div class="popular-section">
          <div class="popular-cards" id="popular-cards">
            <?php foreach (array_slice($popular_posts, 0, 4) as $popular_post) : ?>
                <?php
                $card_excerpt = get_the_excerpt($popular_post);
                if ($card_excerpt === '') {
                    $card_excerpt = get_the_content(null, false, $popular_post);
                }
                $card_image = get_the_post_thumbnail_url($popular_post, 'medium');
                $card_image = $card_image ? $card_image : $popular_default_thumb;
                ?>
              <div class="card-container">
                <div class="card-img">
                  <a href="<?php echo esc_url(get_permalink($popular_post)); ?>">
                    <img src="<?php echo esc_url($card_image); ?>" alt="<?php echo esc_attr(get_the_title($popular_post)); ?>" />
                  </a>
                </div>
                <div class="text-container">
                  <h2 class="title">
                    <a href="<?php echo esc_url(get_permalink($popular_post)); ?>">
                      <?php echo esc_html(get_the_title($popular_post)); ?>
                    </a>
                  </h2>
                  <p class="discription">
                    <?php echo esc_html(wp_trim_words(wp_strip_all_tags($card_excerpt), 18, '…')); ?>
                  </p>

                  <span class="author"><?php echo esc_html(get_the_date('F j', $popular_post)); ?> | <?php echo esc_html(get_the_author_meta('display_name', $popular_post->post_author)); ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
    </section>

    <!-- ads -->
    <hr class="vector" />
    <div
      class="image-background img-height"
      style="
              background-image: url('image/ads-image.jpg');
              background-blend-mode: multiply;
              background-size: cover;
              background-position: center;
            "></div>
    <hr class="vector" />

    <!-- issues -->
    <section class="card-wrap">
      <div class="nav-link">
        <h3>issues</h3>
        <a href="article.html">
          <h3>SEE MORE</h3>
          <img src="image/next-link.png" alt="" />
        </a>
      </div>

      <div class="card-section">
        <div class="cards-grid">
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 12.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <!-- ads -->
          <div class="image">
            <img src="image/friday-sales.png" alt="ads-image" />
          </div>
          <!-- ads -->
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 11.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 9.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr class="vector" />
    <!-- issues -->

    <!-- Literature -->
    <section class="card-wrap">
      <div class="nav-link">
        <h3>Literature</h3>
        <a href="literature.html">
          <h3>SEE MORE</h3>
          <img src="image/next-link.png" alt="" />
        </a>
      </div>

      <div class="card-section">
        <div class="cards-grid">
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 12.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 6.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 11.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 9.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr class="vector" />
    <!-- Literature -->

    <!-- Pop of Culture -->
    <section class="card-wrap">
      <div class="nav-link">
        <h3>Pop of Culture</h3>
        <a href="pop-of-culture.html">
          <h3>SEE MORE</h3>
          <img src="image/next-link.png" alt="" />
        </a>
      </div>

      <div class="card-section">
        <div class="cards-grid">
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 12.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 6.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 11.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 9.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr class="vector" />
    <!-- Pop of Culture -->

    <!-- Lifestyle -->
    <section class="card-wrap">
      <div class="nav-link">
        <h3>Lifestyle</h3>
        <a href="literature.html">
          <h3>SEE MORE</h3>
          <img src="image/next-link.png" alt="" />
        </a>
      </div>

      <div class="card-section">
        <div class="cards-grid">
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 12.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 6.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 11.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 9.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr class="vector" />
    <!-- Lifestyle -->

    <!-- Politics -->
    <section class="card-wrap">
      <div class="nav-link">
        <h3>Politics</h3>
        <a href="pop-of-culture.html">
          <h3>SEE MORE</h3>
          <img src="image/next-link.png" alt="" />
        </a>
      </div>

      <div class="card-section">
        <div class="cards-grid">
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 12.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 6.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 11.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
          <div class="card-container">
            <div class="card-img">
              <img src="image/image 9.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr class="vector" />
    <!-- Politics -->

    <!-- Cartoons and Crosswords -->
    <section class="cartoon-container">
      <div class="nav-link">
        <h3>Cartoons and Crosswords</h3>
        <a href="cartoons-&-crosswords.html">
          <h3>SEE MORE</h3>
          <img src="image/next-link.png" alt="" />
        </a>
      </div>

      <div class="cartoon-cards">
        <!-- first image hidden on mobile -->
        <div class="first-cartoon-card">
          <div class="card-cartoon-container">
            <div class="card-img">
              <img src="image/words.png" alt="card-image" />
            </div>
            <div class="text-container">
              <h2 class="title">
                The Power of Brotherhood: Inspiring Stories of Unity
              </h2>
              <p class="discription">
                From ancient times to modern communities, brotherhood has
                shaped societies. Discover powerful stories of friendship,
                loyalty, and unbreakable bonds that stand the test of
                time.
              </p>

              <span class="author">July 31 | Oyedele Alokan</span>
            </div>
          </div>
        </div>
        <!-- first image hidden on mobile -->
        <div class="second-card">
          <div class="first-cartoon-child">
            <div class="card-cartoon-container card-1">
              <div class="card-img">
                <img src="image/cross.jpg" alt="card-image" />
              </div>
              <div class="text-container">
                <h2 class="title">Title Of SECTION Post</h2>
                <p class="discription">
                  Description of post and additional details in support of
                  the detail to provide more information to the reader on
                  the content of the post and related matters therein to
                  add...
                </p>

                <span class="author">July 31 | Oyedele Alokan</span>
              </div>
            </div>
            <div class="card-cartoon-container card-2">
              <div class="card-img">
                <img src="image/b2b62b87d234f356428c54dd6341a882e0df5e7e.png" alt="card-image" />
              </div>
              <div class="text-container">
                <h2 class="title">Title Of SECTION Post</h2>
                <p class="discription">
                  Description of post and additional details in support of
                  the detail to provide more information to the reader on
                  the content of the post and related matters therein to
                  add...
                </p>

                <span class="author">July 31 | Oyedele Alokan</span>
              </div>
            </div>
          </div>
          <div class="first-cartoon-child">
            <div class="card-cartoon-container card-1">
              <div class="card-img">
                <img src="image/image 11.png" alt="card-image" />
              </div>
              <div class="text-container">
                <h2 class="title">Title Of SECTION Post</h2>
                <p class="discription">
                  Description of post and additional details in support of
                  the detail to provide more information to the reader on
                  the content of the post and related matters therein to
                  add...
                </p>

                <span class="author">July 31 | Oyedele Alokan</span>
              </div>
            </div>
            <div class="card-cartoon-container card-2">
              <div class="card-img">
                <img src="image/image 8.png" alt="card-image" />
              </div>
              <div class="text-container">
                <h2 class="title">Title Of SECTION Post</h2>
                <p class="discription">
                  Description of post and additional details in support of
                  the detail to provide more information to the reader on
                  the content of the post and related matters therein to
                  add...
                </p>

                <span class="author">July 31 | Oyedele Alokan</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr class="vector" />
    <!-- Cartoons and Crosswords -->

    <section class="card-wrap" style="margin-bottom: 30px;">
      <div class="nav-link">
        <h3>CONTRIBUTORS</h3>
      </div>
      <div class="card-section">
        <div class="cards-grid">
          <div class="contributors">
            <div>
              <div
                class="contributor-image"
                style="width: 96px !important; height: 96px !important">
                <img src="image/contributor1.png" alt="" />
              </div>
            </div>
            <div class="contributor-text-box">
              <h2 class="name">Oyedele Alokan</h2>
              <p class="discription">
                Description of post and additional details in support of
                the detail to provide more information to the reader on
                the content of the post...
              </p>
            </div>
          </div>
          <div class="contributors">
            <div>
              <div
                class="contributor-image"
                style="width: 96px !important; height: 96px !important">
                <img src="image/contributor2.png" alt="" />
              </div>
            </div>
            <div class="contributor-text-box">
              <h2 class="name">Oyedele Alokan</h2>
              <p class="discription">
                Description of post and additional details in support of
                the detail to provide more information to the reader on
                the content of the post...
              </p>
            </div>
          </div>
          <div class="contributors">
            <div>
              <div
                class="contributor-image"
                style="width: 96px !important; height: 96px !important">
                <img src="image/contributor3.png" alt="" />
              </div>
            </div>
            <div class="contributor-text-box">
              <h2 class="name">Oyedele Alokan</h2>
              <p class="discription">
                Description of post and additional details in support of
                the detail to provide more information to the reader on
                the content of the post...
              </p>
            </div>
          </div>
          <div class="contributors">
            <div>
              <div
                class="contributor-image"
                style="width: 96px !important; height: 96px !important">
                <img src="image/contributor4.png" alt="" />
              </div>
            </div>
            <div class="contributor-text-box">
              <h2 class="name">Oyedele Alokan</h2>
              <p class="discription">
                Description of post and additional details in support of
                the detail to provide more information to the reader on
                the content of the post...
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
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
<!-- Reusable Topic Card Template -->

<!-- ads -->
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
      Subscribe to our newsletter to get weekly updates to your inbox.
    </h2>

    <div class="email-container">
      <form action="" method="post">
        <input
          type="email"
          name="email"
          autocomplete="email"
          placeholder="Email" />
        <button type="submit">Subscribe</button>
      </form>
    </div>
  </div>
</div>
