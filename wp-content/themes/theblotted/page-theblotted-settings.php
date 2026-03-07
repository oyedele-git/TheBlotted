<?php
/**
 * Template Name: Theme Ad Settings
 *
 * A non-public page used by editors to manage global ad images.
 * Create a page in WP Admin → Pages, title it anything (e.g. "Ad Settings"),
 * assign this template, then upload ad images via the ACF fields below.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

// Only render if the user is logged in and has edit permissions
if ( ! current_user_can( 'edit_posts' ) ) {
    wp_redirect( home_url( '/' ) );
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title>Ad Settings — <?php bloginfo( 'name' ); ?></title>
    <?php wp_head(); ?>
</head>
<body>
<div style="max-width:600px;margin:60px auto;font-family:sans-serif;color:#333;">
    <h1 style="font-size:24px;margin-bottom:8px;">Theme Ad Settings</h1>
    <p style="color:#666;">This page is not visible to site visitors. Use the ACF fields below (in the page editor) to manage global ad images across the site.</p>
</div>
<?php wp_footer(); ?>
</body>
</html>
