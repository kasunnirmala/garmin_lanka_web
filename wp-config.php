<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'garmin_lk_2' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'AN|(/w$|2e0he~%KYXmx*OK18z=7r;c5OLcl|UG}f7EY#;Mfs3<P`)H_%Bx6N`&V' );
define( 'SECURE_AUTH_KEY',  'pJaTz,n#s^}dJuI4l>_*-sT,@G|ELa:gVN2tlMn8)D81V@ND2ayQ-sUDA~UB(k[,' );
define( 'LOGGED_IN_KEY',    'J]l}9N]<t5:0w(b,E@a4+?d?;0pkA7}+Qa_Q%pZi4tkOKYfG3-:,X~46|e58DX2l' );
define( 'NONCE_KEY',        'z|U/ZS3S[^|q<RYChDy0Wu53-Ly6)d1U#7<O{1H6ns{,1x0jW=AGnc :1#U:U$i[' );
define( 'AUTH_SALT',        'MS/:GBD^p]QvJ (Ee`i0?iaxMnwPgpo,*%yV|8|ZbmHl(2D5+`I0*vx@{bY;y:^6' );
define( 'SECURE_AUTH_SALT', '!YJ-t$r6||L9o)N&n3C#R1~x.wy2#$g`*m_,8lm0Dbx&vDD%wyy)bU0OeDhGA{GZ' );
define( 'LOGGED_IN_SALT',   'IH5)KBp~qmFC>-; ~$oO!9K?%BcF#Ts~{{VcKY9HSCk[Aw}hUj,#n l2~qwk503~' );
define( 'NONCE_SALT',       'C^QASfK1`Ingg)<|S9k/;6h!mdzH(>%b@+3#,BgdYVg}JEKUCLxFq=3uJk+UeeA9' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
