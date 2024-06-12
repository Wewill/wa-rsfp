<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.wilhemarnoldy.fr
 * @since             1.6
 * @package           Wa_Rsfp
 *
 * @wordpress-plugin
 * Plugin Name:       WA RSFP Global functions
 * Plugin URI:        https://www.wilhemarnoldy.fr
 * Description:       A plugin to add directory, knowledges, farms, farmers, structures, operations, partners of "le Répertoire des Savoir-faire Paysans"
 * Version:           1.6
 * Author:            Wilhem Arnoldy
 * Author URI:        https://www.wilhemarnoldy.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wa-rsfp
 * Domain Path:       /languages
 * https://wppb.me
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if( !defined("IS_ADMIN"))
	define("IS_ADMIN",  is_admin());

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WA_RSFP_VERSION', '1.6' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wa-rsfp-activator.php
 */
function activate_wa_rsfp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wa-rsfp-activator.php';
	Wa_Rsfp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wa-rsfp-deactivator.php
 */
function deactivate_wa_rsfp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wa-rsfp-deactivator.php';
	Wa_Rsfp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wa_rsfp' );
register_deactivation_hook( __FILE__, 'deactivate_wa_rsfp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wa-rsfp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wa_rsfp() {

	$plugin = new Wa_Rsfp();
	$plugin->run();

}
run_wa_rsfp();