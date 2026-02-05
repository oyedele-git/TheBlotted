<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package theblotted
 */

// Social Handles
$footer_instagram = get_theme_mod('the-blotted-instagram-setting');
$footer_facebook = get_theme_mod('the-blotted-facebook-setting');
$footer_threads  = get_theme_mod('the-blotted-threads-setting');
$footer_twitter  = get_theme_mod('the-blotted-twitter-setting');

// Footer menu items
$footer_menu_items = [];
$menu_locations    = get_nav_menu_locations();

if (!empty($menu_locations['footer-menu'])) {
	$footer_menu      = wp_get_nav_menu_object($menu_locations['footer-menu']);
	$footer_menu_items = $footer_menu ? wp_get_nav_menu_items($footer_menu->term_id) : [];
}

if (!function_exists('theblotted_render_footer_links')) {
	/**
	 * Render footer links with optional active styling.
	 */
	function theblotted_render_footer_links($menu_items, $emphasize_dark = false)
	{
		$home_url = trailingslashit(home_url('/'));
		echo '<ul class="links-list">';
		if (!empty($menu_items)) {
			foreach ($menu_items as $item) {
				$link_url     = !empty($item->url) ? $item->url : '#';
				$is_home_link = untrailingslashit($link_url) === untrailingslashit($home_url);
				$style_attr   = '';
				if ($is_home_link) {
					$style_attr = $emphasize_dark ? 'font-weight: 700 !important; color: #111827 !important;' : 'font-weight: 700 !important;';
				}
				?>
					<li class="link">
						<a href="<?php echo esc_url($link_url); ?>">
							<p<?php echo $style_attr ? ' style="' . esc_attr($style_attr) . '"' : ''; ?>>
								<?php echo esc_html($item->title); ?>
							</p>
						</a>
					</li>
				<?php
			}
		} else {
			$default_links = [
				['title' => __('home', 'theblotted'), 'url' => home_url('/')],
				['title' => __('Issues', 'theblotted'), 'url' => get_permalink(get_page_by_path('issues'))],
				['title' => __('literature', 'theblotted'), 'url' => get_permalink(get_page_by_path('literature'))],
				['title' => __('Pop Of Culture', 'theblotted'), 'url' => get_permalink(get_page_by_path('pop-of-culture'))],
				['title' => __('lifestyle', 'theblotted'), 'url' => get_permalink(get_page_by_path('lifestyle'))],
				['title' => __('comedy', 'theblotted'), 'url' => get_permalink(get_page_by_path('comedy'))],
				['title' => __('Cartoons & Crosswords', 'theblotted'), 'url' => get_permalink(get_page_by_path('cartoons-crosswords'))],
				['title' => __('About', 'theblotted'), 'url' => get_permalink(get_page_by_path('about-us'))],
			];
			foreach ($default_links as $default) {
				if (empty($default['url'])) {
					continue;
				}
				$is_home_link = untrailingslashit($default['url']) === untrailingslashit($home_url);
				$style_attr   = '';
				if ($is_home_link) {
					$style_attr = $emphasize_dark ? 'font-weight: 700 !important; color: #111827 !important;' : 'font-weight: 700 !important;';
				}
				?>
					<li class="link">
						<a href="<?php echo esc_url($default['url']); ?>">
							<p<?php echo $style_attr ? ' style="' . esc_attr($style_attr) . '"' : ''; ?>>
								<?php echo esc_html($default['title']); ?>
							</p>
						</a>
					</li>
				<?php
			}
		}
		echo '</ul>';
	}
}
?>

<footer class="show">
	<div class="app-wrapper">
		<div>
			<div class="logo">
				<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/image1.png'); ?>" alt="<?php esc_attr_e('The Blotted logo', 'theblotted'); ?>" />
			</div>

			<div class="link-wrap">
				<?php theblotted_render_footer_links($footer_menu_items, true); ?>
			</div>

			<ul class="social-media">
				<?php if (!empty($footer_instagram)) : ?>
					<li class="media">
						<a href="<?php echo esc_url($footer_instagram); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/Instagram.png'); ?>" alt="Instagram" />
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($footer_facebook)) : ?>
					<li class="media">
						<a href="<?php echo esc_url($footer_facebook); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/facebook.png'); ?>" alt="Facebook" />
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($footer_threads)) : ?>
					<li class="media">
						<a href="<?php echo esc_url($footer_threads); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/icons@.png'); ?>" alt="Threads" />
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($footer_twitter)) : ?>
					<li class="media">
						<a href="<?php echo esc_url($footer_twitter); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/x.png'); ?>" alt="Twitter" />
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
		<div>
			<h4>
				© <?php echo esc_html(date('Y')); ?> TheBlotted. All Rights Reserved.
			</h4>
		</div>
	</div>
</footer>

<footer class="hide">
	<div
		class="image-background"
		style="
			background-color: #8e8585;
			padding-top: 100px;
			padding-bottom: 100px;
			width: 100%;
		"
	>
		<div class="email-box" style="width: 273px">
			<h2 style="font-size: 24px">
				<?php esc_html_e('Subscribe to our newsletter to get weekly updates to your inbox.', 'theblotted'); ?>
			</h2>

			<div class="email-container">
				<form action="#" method="post">
					<input
						type="email"
						name="newsletter-email"
						autocomplete="email"
						placeholder="<?php esc_attr_e('Email', 'theblotted'); ?>"
						required
					/>
					<button type="submit"><?php esc_html_e('Subscribe', 'theblotted'); ?></button>
				</form>
			</div>
		</div>
	</div>
	<div class="app-wrapper">
		<div>
			<div class="logo">
				<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/image1.png'); ?>" alt="<?php esc_attr_e('The Blotted logo', 'theblotted'); ?>" />
			</div>

			<div class="link-wrap">
				<?php theblotted_render_footer_links($footer_menu_items, false); ?>
			</div>

			<ul class="social-media">
				<?php if (!empty($footer_instagram)) : ?>
					<li class="media">
						<a href="<?php echo esc_url($footer_instagram); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/Instagram.png'); ?>" alt="Instagram" />
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($footer_facebook)) : ?>
					<li class="media">
						<a href="<?php echo esc_url($footer_facebook); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/facebook.png'); ?>" alt="Facebook" />
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($footer_threads)) : ?>
					<li class="media">
						<a href="<?php echo esc_url($footer_threads); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/icons@.png'); ?>" alt="Threads" />
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($footer_twitter)) : ?>
					<li class="media">
						<a href="<?php echo esc_url($footer_twitter); ?>" target="_blank" rel="noopener">
							<img src="<?php echo esc_url(THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/x.png'); ?>" alt="Twitter" />
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
		<div>
			<h4>
				© <?php echo esc_html(date('Y')); ?> TheBlotted. All Rights Reserved.
			</h4>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
