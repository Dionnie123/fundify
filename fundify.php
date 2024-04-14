<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://markdionniebulingit.vercel.app/
 * @since             1.0.0
 * @package           Fundify
 *
 * @wordpress-plugin
 * Plugin Name:       Fundify
 * Plugin URI:        https://https://fundify.vercel.app/
 * Description:       Whether you're running a nonprofit campaign, a personal fundraiser, or a creative project, Fundify offers customizable donation forms that seamlessly integrate with your WordPress site. With just a few clicks, you can set up compelling fundraising campaigns and start accepting donations from supporters around the world.
 * Version:           1.0.0
 * Author:            Mark Dionnie
 * Author URI:        https://https://markdionniebulingit.vercel.app//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fundify
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FUNDIFY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fundify-activator.php
 */
function activate_fundify() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fundify-activator.php';
	Fundify_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fundify-deactivator.php
 */
function deactivate_fundify() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fundify-deactivator.php';
	Fundify_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fundify' );
register_deactivation_hook( __FILE__, 'deactivate_fundify' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fundify.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fundify() {

	$plugin = new Fundify();
	$plugin->run();

}
run_fundify();
