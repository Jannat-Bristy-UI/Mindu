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
define( 'DB_NAME', 'mindu' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'l!U3~39+$:nN5b,{_{9qV[F1?thkn-/t|Ua{[/4 S+c4G@d_GnM{91`]P]_)wkvZ' );
define( 'SECURE_AUTH_KEY',  'W^GWv><Cj2Y?fNm3%azhBu@_NwRe7-1jHqG{`nmqH?/%[|-|dygry7,>&<-O &5H' );
define( 'LOGGED_IN_KEY',    '[-IkAOUS#>L!dnW:^{P9EzjojKvaD/&b&4`0I*(k+Ut4laikLw]|!iC2n9#R]!CJ' );
define( 'NONCE_KEY',        '=Qeu~TFUMd1h1&$47_{AOKZI)$sd7v`6pj`}N.6*f4ZYphiP8R+/v{9e(NO+?:~?' );
define( 'AUTH_SALT',        '8sW~hf/{)(VC%!.7{ U@}~MQAjNG|m/oNYY+f$]9}6o@$SwL78p+4v0q&/H{BCAW' );
define( 'SECURE_AUTH_SALT', ']2Ry2Ip;18?z~M1H{YpdbSE6FE1yF+ANcBMJ]{&k+FB|K3_Y1k+fo$xX?{N=`+=h' );
define( 'LOGGED_IN_SALT',   'Aq6iz`4p<y7z[gW61<hwoG7)BieQ40R>;+As#BRNX{L_I!WF(5bR7xXFVZ!|r,OS' );
define( 'NONCE_SALT',       'RMb#1{~0^EE@W-yc.uo0O.kyJwXz8^}[P7^O5s^ojc-Z><5<#,=)~M^g#)pg4ul4' );

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

@ini_set( 'display_errors', 0 );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
