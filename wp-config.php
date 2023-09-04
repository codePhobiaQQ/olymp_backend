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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'olymp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost:8889' );

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
define( 'AUTH_KEY',         ',;8:/2kBk^r6 ~]#O&rCvyjAq?^*.^c1N`irK|@zO!TZ9EO|$!AV`9:D49x^V`F{' );
define( 'SECURE_AUTH_KEY',  'l@[a~QJ8]yB5V@[,[3M$zTFm]DSn2f[p,O=(d0aLSLs~eUAo81[w}G#BHWwTHYDd' );
define( 'LOGGED_IN_KEY',    'fylIBS9fBLZ}X[k:FMtWfUR%MZoX.u {xcaO724wrjbf@*^HvWJpW/|yY0Y|.p}_' );
define( 'NONCE_KEY',        'F,Mp6t1Xq7k4a*6_64@i)Fp?<J/2RzM&_NP:%&lfzMPxpuVyqA+y ~<qV&rDm%xo' );
define( 'AUTH_SALT',        'MJ9RY{)HM=p&vKM|Nd]`Q*$bRZt/D6xQ>]]>Z0$1=/.LV!a?h4/Byj)@[]h9h(lL' );
define( 'SECURE_AUTH_SALT', '4)ZUEk <K^oMtc]`3CI7KXt<#+1U-lefBT)$yu<s4NtW I;5L0W4%2=Z:KHD#r,D' );
define( 'LOGGED_IN_SALT',   'E0S1#gm{(n]|/x0A;9`8D7)peBK?FZ%GCtC3JxD=km=lwXjx4!#7Q$X?$7-R)=NK' );
define( 'NONCE_SALT',       '0=m>l2=~TVEQ^fg@K{m4+>DkrU2%36i LG*D&}#mJm2{XUdxI8Gy4P<HLaE*<iPK' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */


/* Add any custom values between this line and the "stop editing" line. */

define( 'WP_DEBUG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
