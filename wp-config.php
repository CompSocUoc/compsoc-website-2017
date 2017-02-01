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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'compsocdb');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '(Fp$e7fA+ci&C u?F/ZRtCX+g=Q]f0RXj:n7@+[K]aFh7sc/lo^x7QZY 6sk-Vlb');
define('SECURE_AUTH_KEY',  '-- .RfTZE>1,c{jI&&DhQUb4bXIS4Lp&lnPNvJA:+UO6Sz-Eg?5/o1spvol:{zA1');
define('LOGGED_IN_KEY',    '+$1Sizh>e?!#%bf!^71.w@,Jm9ynobt>r=0uwn0vez#qs2?yWB$~Jx!:Sn+~Hm:r');
define('NONCE_KEY',        '.GT&#}a f;+__8Lp=^}Gdx_R7V>1=YG)bac)?7,rl!7Nk5GhA*q`;RU2m1|=F2uj');
define('AUTH_SALT',        'BE],@E%x%~ waO9Xg]#ZlNZzRb9sLmr{d%n~FGW#pQ+2j69KE f)O4JAn~gy.gz@');
define('SECURE_AUTH_SALT', ':KN}m6aV$#D4st_k9xItIi@ArQX9b|-(<-UvfOz^v,0p<q[MVIz|gI xeA L8dV0');
define('LOGGED_IN_SALT',   '+5Ww.Bd+7xy!`)yj=Djtp=n5hS|bf1#Zd|$ S@52x.H`2Bv6KG]GO)U${yo9`&rI');
define('NONCE_SALT',       'NY0P?5rS~,Lltps*V)W?g,01G5L:7ltcD 8NgK5g+ENx>3!kJlM_Icw]+9=6yG6b');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpcs_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
