<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://thediamondport.com/
 * @since      1.0.0
 *
 * @package    Tdp_Ring_Builder
 * @subpackage Tdp_Ring_Builder/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Tdp_Ring_Builder
 * @subpackage Tdp_Ring_Builder/includes
 * @author     TDP <tdp@gmail.com>
 */
class TDP_Ring_Builder {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      TDPRB_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'TDPRB_VERSION' ) ) {
			$this->version = TDPRB_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'tdp-ring-builder';
		$this->tdprb_constants();
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - TDPRB_Loader. Orchestrates the hooks of the plugin.
	 * - TDPRB_i18n. Defines internationalization functionality.
	 * - TDPRB_Admin. Defines all hooks for the admin area.
	 * - TDPRB_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-tdprb-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-tdprb-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-tdprb-public.php';
		$this->loader = new TDPRB_Loader();

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new TDPRB_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', 				$plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', 				$plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', 							$plugin_admin, 'tdprb_add_menu' );
		$this->loader->add_action( 'admin_init', 							$plugin_admin, 'register_general_settings' );
		$this->loader->add_action( 'admin_init', 							$plugin_admin, 'register_lab_settings' );
		$this->loader->add_action( 'admin_init', 							$plugin_admin, 'register_natural_settings' );
		$this->loader->add_action( 'admin_init', 							$plugin_admin, 'register_ring_settings' );
		$this->loader->add_action( 'wp_ajax_tdprb_token_save', 				$plugin_admin, 'tdprb_token_save_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_token_save', 		$plugin_admin, 'tdprb_token_save_callback' );
		$this->loader->add_action( 'wp_ajax_tdprb_token_deactivate', 		$plugin_admin, 'tdprb_token_deactivate_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_token_deactivate',	$plugin_admin, 'tdprb_token_deactivate_callback' );
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new TDPRB_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', 							$plugin_public,  'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', 							$plugin_public,  'enqueue_scripts' );
		$this->loader->add_shortcode( 'Ring_Builder', 	 							$plugin_public,  'tdprb_callback' );
		$this->loader->add_action( 'rest_api_init', 	 							$plugin_public,  'tdprb_register_api_endpoints' );
		$this->loader->add_action( 'init',  			 							$plugin_public,  'tdprb_register_custom_rewrite_rules' );
		$this->loader->add_filter( 'query_vars', 		 							$plugin_public,  'tdprb_add_custom_query_vars' );
		$this->loader->add_filter( 'template_include',   							$plugin_public,  'tdprb_handle_custom_template' );
		$this->loader->add_action( 'wp_ajax_tdprb_diamond_list_ajax', 				$plugin_public,  'tdprb_diamond_list_ajax_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_diamond_list_ajax', 		$plugin_public,  'tdprb_diamond_list_ajax_callback' );
		$this->loader->add_action( 'wp_ajax_tdprb_diamond_details_ajax', 			$plugin_public,  'tdprb_diamond_details_ajax_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_diamond_details_ajax', 	$plugin_public,  'tdprb_diamond_details_ajax_callback' );
		$this->loader->add_action( 'wp_ajax_tdprb_rings_list_ajax', 				$plugin_public,  'tdprb_rings_list_ajax_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_rings_list_ajax', 			$plugin_public,  'tdprb_rings_list_ajax_callback' );
		$this->loader->add_action( 'wp_ajax_tdprb_ring_details_ajax', 				$plugin_public,  'tdprb_ring_details_ajax_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_ring_details_ajax', 		$plugin_public,  'tdprb_ring_details_ajax_callback' );
		$this->loader->add_filter( 'woocommerce_cart_item_permalink', 				$plugin_public,  'tdprb_custom_cart_item_permalink', 10, 3 );
		$this->loader->add_action( 'wp_ajax_tdprb_loosediamond_add_to_cart', 		$plugin_public,  'tdprb_loosediamond_add_to_cart_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_loosediamond_add_to_cart', $plugin_public,  'tdprb_loosediamond_add_to_cart_callback' );
		$this->loader->add_action( 'wp_ajax_tdprb_loosering_add_to_cart', 			$plugin_public,  'tdprb_loosering_add_to_cart_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_loosering_add_to_cart', 	$plugin_public,  'tdprb_loosering_add_to_cart_callback' );
		$this->loader->add_action( 'wp_ajax_tdprb_completering_add_to_cart', 		$plugin_public,  'tdprb_completering_add_to_cart_callback' );
		$this->loader->add_action( 'wp_ajax_nopriv_tdprb_completering_add_to_cart', $plugin_public,  'tdprb_completering_add_to_cart_callback' );
		$this->loader->add_filter( 'woocommerce_get_item_data', 					$plugin_public, 'tdprb_display_custom_data_in_cart', 10, 2 );
		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', 	$plugin_public,	'tdprb_add_custom_data_to_order_item', 10, 4 );
		//$this->loader->add_action( 'woocommerce_order_item_meta_end', 				$plugin_public, 'tdprb_display_custom_data_in_order', 10, 4);
		//$this->loader->add_action( 'woocommerce_thankyou', 							$plugin_public,	'tdprb_store_custom_meta_on_purchase', 10, 1);
		$this->loader->add_filter( 'allowed_http_origins', 							$plugin_public, 'add_allowed_origins' );
		$this->loader->add_action( 'woocommerce_thankyou', 							$plugin_public, 'tdprb_order_placed_api_call', 10, 1 );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Tdp_Rb_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Define all of the constants used in the plugin.
	 *
	 * @return void
	 */
	public function tdprb_constants() {		
		define( 'TDPRB_DIR_PATH', 	  				dirname(plugin_dir_path( __FILE__ )) );
		define( 'TDPRB_PLUGIN_URL', 				dirname(plugin_dir_url( __FILE__ )) );
		define( 'TDPRB_BASENAME', 	  				dirname(dirname(plugin_basename(__FILE__))) );
		define( 'TDPRB_ACCESS_TOKEN',  	  			get_option( 'tdprb-access-token-val', true ) );
		define( 'TDPRB_ACCESS_TOKEN_URL', 			'https://integrations.thediamondport.com/feed/rb_get_config' );
		define( 'TDPRB_DIAMOND_SEARCH_API', 		'https://integrations.thediamondport.com/feed/rb_search_diamond?page=' );
		define( 'TDPRB_DIAMOND_SINGLE_SEARCH_API', 	'https://integrations.thediamondport.com/feed/rb_single_diamond' );
		define( 'TDPRB_RINGS_SEARCH_API', 			'https://integrations.thediamondport.com/feed/rb_get_rings?page=' );
		define( 'TDPRB_RING_SINGLE_SEARCH_API', 	'https://integrations.thediamondport.com/feed/rb_single_ring' );
		define( 'TDPRB_ORDER_PLACE_API',  			'https://integrations.thediamondport.com/feed/rb_order_place' );
		define( 'TDPRB_PRODUCT_SYNC', 				'https://integrations.thediamondport.com/feed/rb_product_sync' );
	}
}
