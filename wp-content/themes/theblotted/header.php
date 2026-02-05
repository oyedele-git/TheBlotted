<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package theblotted
 * 
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site site-wrapper">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'theblotted' ); ?></a>

	<header id="navbar" class="site-header">
		<div class="app-wrapper">
			<nav>
				<hr class="vector vec-1" />
				<div class="image-container">
					<span class="element">
						<div class="openMenu" id="openMenu" role="button" tabindex="0" aria-controls="primary-menu" aria-expanded="false">
							<img id="icon" src="<?php echo esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/Hamburger.png' ); ?>" alt="<?php esc_attr_e( 'Open menu', 'theblotted' ); ?>" />
						</div>
						<div class="closeMenu" id="closeMenu" role="button" tabindex="0" style="display: none" aria-controls="primary-menu" aria-expanded="true">
							<img id="icon" src="<?php echo esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/Hamburger-close.png' ); ?>" alt="<?php esc_attr_e( 'Close menu', 'theblotted' ); ?>" />
						</div>
					</span>
					<div class="logo-image">
						<?php
						if ( has_custom_logo() ) {
							echo get_custom_logo();
						} else {
							?>
							<img src="<?php echo esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/image1.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
							<?php
						}
						?>
					</div>
					<span class="search">
						<img class="search-img" src="<?php echo esc_url( THEBLOTTED_ASSETS_DIR_IMAGES_URI . '/icon/search.png' ); ?>" alt="<?php esc_attr_e( 'Search', 'theblotted' ); ?>" />
					</span>
				</div>
				<hr class="vector vec-2" />
				<div class="menu-list">
					<div id="open1" class="list-wrap">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'main-menu',
								'menu_class'      => 'list-dropdown',
								'menu_id'         => 'primary-menu',
								'container'       => false,
								'fallback_cb'     => false,
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'walker'          => new \TheBlottedWP\Core\MainMenu_Walker(),
							)
						);
						?>
					</div>
				</div>
				<hr class="vector vec-3" />
			</nav>
		</div>
	</header>
