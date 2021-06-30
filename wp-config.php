<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
 
require_once('config.php');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
//define( 'DB_NAME', 'galleryvn' );

/** MySQL database username */
//define( 'DB_USER', 'root' );

/** MySQL database password */
//define( 'DB_PASSWORD', '' );

/** MySQL hostname */
//define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'X)sRg.QKM*K&s}~=d)oX~4OGLYQp+-Ya|y>!vf(b9g:Mb1]B)6zmQ9i.f0 3AG|I' );
define( 'SECURE_AUTH_KEY',  '.{~;YrC;M|*ocSbHviNQ+K3FDIghX!/UN[o gqPZZn+QdZ%n5K3JS!zf]t*B]$IW' );
define( 'LOGGED_IN_KEY',    '|)DY/UFCacxjz@wP]@Y|!eknRYOjn Y<T&:aX;QsO;@TFx$5GT22d_2%~zgUQty8' );
define( 'NONCE_KEY',        '24[=[QW!irjYq|1r]sWT7*T{3`#1Lw=+I*q8YvwyN0dQ08V)cc,p)srTiuri_d)1' );
define( 'AUTH_SALT',        '1[2*P}-M^b%=LpOOlF`g0#y I=w^Ubc3> K]4w1vq``.t& xtr(#g@$XSKW>|I3J' );
define( 'SECURE_AUTH_SALT', '?KYhP<=#]-7DW,|K]M%C3tm)?XcP/%UU]XBs:PWmRiar&6=j~GfdmoK,G@? dSW[' );
define( 'LOGGED_IN_SALT',   'c|q_X2%bg3Ws=Dh:jo1@V%LPx<EuME8a2gRqS)p]R/8mK6ADkhyR4<3:H(Y@-;zt' );
define( 'NONCE_SALT',       'j}>^{h<]dy9Pn>32O^u><b3Ag]dG/$4T@l Jval`MI`:a^5fOjOu7}J4{VZ+l4q^' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'gvn_';

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
//define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
