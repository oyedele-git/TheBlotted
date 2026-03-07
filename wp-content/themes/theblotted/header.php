<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and the site header up to the opening
 * of the main page content area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package theblotted
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ═══════════════════════════════════════════════════
     HEADER
══════════════════════════════════════════════════════ -->
<header id="site-header">
  <div class="header-inner">

    <!-- LOGO ROW -->
    <div class="logo-row">
      <!-- Mobile only: hamburger -->
      <div class="mob-left">
        <button class="icon-btn" id="hamburger-btn" aria-label="<?php esc_attr_e('Open menu', 'theblotted'); ?>">&#9776;</button>
      </div>

      <!-- Text logo linking to homepage -->
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <span class="logo-text">THEB<span class="ink">L</span>OTTED</span>
      </a>

      <!-- Mobile only: search -->
      <div class="mob-right">
        <button class="icon-btn" aria-label="<?php esc_attr_e('Search', 'theblotted'); ?>">&#128269;</button>
      </div>
    </div>

    <hr class="divider"/>

    <!-- DESKTOP NAV -->
    <nav class="desktop-nav">
      <?php
      wp_nav_menu([
        'theme_location' => 'main-menu',
        'container'      => false,
        'menu_class'     => '',
        'items_wrap'     => '%3$s',
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>

    <hr class="divider"/>

  </div><!-- /header-inner -->

  <!-- MOBILE NAV DRAWER (toggled by hamburger) -->
  <nav class="mobile-nav-drawer" id="mobile-nav">
    <?php
    wp_nav_menu([
      'theme_location' => 'main-menu',
      'container'      => false,
      'menu_class'     => '',
      'items_wrap'     => '%3$s',
      'fallback_cb'    => false,
    ]);
    ?>
  </nav>

</header>

<!-- Spacer so page content clears fixed header -->
<div id="header-spacer"></div>
