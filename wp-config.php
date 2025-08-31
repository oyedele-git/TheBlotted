<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'theblott_staging' );

/** Database username */
define( 'DB_USER', 'theblott_stagingU' );

/** Database password */
define( 'DB_PASSWORD', '2R7vz9(#.fr4' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'n%+3{It0B.->i;4sgJm00+]>f]cSM>BaZlmzs0Y]V_UV9Gzn6Oa DC|tdRS.gDI^' );
define( 'SECURE_AUTH_KEY',  'HQE>9N7eq6I `WJVkIxaC0LB>TWWkieJX[@T(_m{24~US2;F}+{@1ae~]ulZx;&B' );
define( 'LOGGED_IN_KEY',    ' Wo;ZxygdgU@F~tL>l#%[o`>(k1j)4%WSpqAY)Wt<i7-]Wxl(#$|UFHy!S){s8&D' );
define( 'NONCE_KEY',        'sTH+GY9qlH$36=mP)V^)P@w_fK;i-uAA%QG|m/hRP/,kpTYI? LZP)UcFp0g//a!' );
define( 'AUTH_SALT',        'YEzs7W(!0x6;`WmLC16VYZ9;J*CT7G[E7P}#iT()Y/WUoW]Xm><u%ZSzHNG^v{&8' );
define( 'SECURE_AUTH_SALT', '{e6VmAxqU;SYZf2kZWI=C7<{d{RAzOr:>QF(D[QRU*~h?[&[Wk=AaNEs_U-]/CNL' );
define( 'LOGGED_IN_SALT',   'ijk`Qb:[50x15(9L~4.5M<47D19E;in`ja]+*Cm,@6[WStB=F+!kh|y!LC^-HiFR' );
define( 'NONCE_SALT',       'bA?u5#of,v14@k78ymlTIO~j|sCI7]tc*7Z|Qh0V&1?zIy2PBcoYUdriJ<sV2s.T' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
