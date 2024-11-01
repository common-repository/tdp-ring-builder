<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://thediamondport.com/
 * @since             1.0.0
 * @package           TDP_Ring_Builder
 *
 * @wordpress-plugin
 * Plugin Name:       TDP Ring Builder
 * Plugin URI:        https://thediamondport.com/
 * Description:       This plugin add Ring builder module to WordPress, WooCommerce with Vue JS.
 * Version:           1.0.0
 * Author:            TDP
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tdp-ring-builder
 * Tested up to: 	  6.6.2
 * Stable Tag: 		  1.0.0
 * Requires PHP: 	  7.0
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
define( 'TDPRB_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tdprb-activator.php
 */
function tdprb_activate() {
	if ( !tdprb_is_supported() ) {
		
		// Deactivate the plugin
		deactivate_plugins( plugin_basename( __FILE__ ) );

		// Display an error message
		wp_die(
			esc_html__( 'WooCommerce plugin is required to activate this plugin. Please install and activate WooCommerce.', 'tdp-ring-builder' ),
			esc_html__( 'Plugin Activation Error', 'tdp-ring-builder' ),
			array( 'back_link' => true )
		);

	} else {
		require_once plugin_dir_path( __FILE__ ) . '/public/class-tdprb-public.php';
		$TDPRB_Public = new TDPRB_Public( 'tdp-ring-builder', TDPRB_VERSION );
		$TDPRB_Public->tdprb_register_custom_rewrite_rules();
		flush_rewrite_rules();
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-tdprb-activator.php';
		TDPRB_Activator::activate();
	}
}

function tdprb_is_supported() {
	// Check for required WooCommerce plugin.
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	return is_plugin_active( 'woocommerce/woocommerce.php' );
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tdprb-deactivator.php
 */
function tdprb_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tdprb-deactivator.php';
	TDPRB_Deactivator::deactivate();
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'tdprb_activate' );
register_deactivation_hook( __FILE__, 'tdprb_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tdprb.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function tdprb_run() {

	$plugin = new TDP_Ring_Builder();
	$plugin->run();

}
tdprb_run();