<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://thediamondport.com/
 * @since      1.0.0
 *
 * @package    TDP_Ring_Builder
 * @subpackage TDP_Ring_Builder/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    TDP_Ring_Builder
 * @subpackage TDP_Ring_Builder/admin
 * @author     TDP <tdp@gmail.com>
 */
class TDPRB_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name = 'tdp-ring-builder', $version = TDPRB_VERSION ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles($hook) {

		
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tdp_Rb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tdp_Rb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$scriptPage = array(
			'toplevel_page_tdp-ring-builder', 
			'tdp-ring-builder_page_tdprb-lab-grown-settings', 
			'tdp-ring-builder_page_tdprb-natural-settings', 
			'tdp-ring-builder_page_tdprb-ring-settings',
			'tdp-ring-builder_page_tdprb-ring-settings-orders'
		);
		if (in_array($hook, $scriptPage)) {
			wp_enqueue_style('wp-codemirror');
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tdprb-admin.css', array(), $this->version, 'all' );
		}
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts($hook) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Tdp_Rb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Tdp_Rb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$scriptPage = array(
			'toplevel_page_tdp-ring-builder', 
			'tdp-ring-builder_page_tdprb-lab-grown-settings', 
			'tdp-ring-builder_page_tdprb-natural-settings', 
			'tdp-ring-builder_page_tdprb-ring-settings',
			'tdp-ring-builder_page_tdprb-ring-settings-orders'
		);
		if (in_array($hook, $scriptPage)) {
		
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script('wp-theme-plugin-editor');
			// Enqueue the code editor with CSS as the mode
			$settings = wp_enqueue_code_editor(array('type' => 'text/css'));
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tdprb-admin.js', array( 'jquery','wp-color-picker' ), $this->version, false );
			wp_localize_script( $this->plugin_name, 'tdprbajax', array( 
				'ajaxurl' 	=> admin_url( 'admin-ajax.php' ) , // WordPress AJAX URL
				'nonce' 	=> wp_create_nonce('tdprb-admin-ajax-nonce'), // WordPress nonce for security
				'settings' 	=> wp_json_encode($settings)
			));	
		}
	}

	/**
	 * Register menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function tdprb_add_menu() {
		add_menu_page(
			__( 'TDP Ring Builder', 'tdp-ring-builder' ),
			'TDP Ring Builder',
			'manage_options',
			'tdp-ring-builder',
			array( $this, 'tdprb_general_settings_page' ),
			'dashicons-superhero-alt',
			5
		);

		// Only add submenu pages if the access token is set
		if ( get_option('tdprb-access-token-val') != '' ) {
			add_submenu_page(
				'tdp-ring-builder',
				'Lab Settings',
				'Lab Settings',
				'manage_options',
				'tdprb-lab-grown-settings',
				array($this, 'lab_settings_page')
			);
	
			add_submenu_page(
				'tdp-ring-builder',
				'Natural Settings',
				'Natural Settings',
				'manage_options',
				'tdprb-natural-settings',
				array($this, 'natural_settings_page')
			);
	
			add_submenu_page(
				'tdp-ring-builder',
				'Ring Settings',
				'Ring Settings',
				'manage_options',
				'tdprb-ring-settings',
				array($this, 'ring_settings_page')
			);

			add_submenu_page(
				'tdp-ring-builder',
				'Orders',
				'Orders',
				'manage_options',
				'tdprb-ring-settings-orders',
				array($this, 'orders_settings_page')
			);
		}
	}

	/**
	 * Ajax callback to save token.
	 *
	 * @since    1.0.0
	 * @return void
	 */
	public function tdprb_token_save_callback() {
		$json = array();
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce(  sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-admin-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}
	
		if ( isset( $_POST['token'] ) ) {
			$token = sanitize_text_field( wp_unslash( $_POST['token'] ) );
			
			$response = wp_remote_post( TDPRB_ACCESS_TOKEN_URL, array(
				'body'        => array( 'token' => $token ),
				'timeout'     => 120,
				'redirection' => 10,
				'httpversion' => '1.1',
				'blocking'    => true,
				'headers'     => array(),
				'cookies'     => array(),
				'sslverify'   => false
			));
	
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				$json['status'] = false;
				$json['message'] = "Something went wrong: $error_message";
				wp_send_json($json);
				return;
			} else {
				$body = wp_remote_retrieve_body( $response );
				$responses = json_decode( $body, true );
				// Check if the response indicates success
				if ( isset($responses['success']) && $responses['success'] ) {
					update_option( 'tdprb-access-token', 1 );
					update_option( 'tdprb-access-token-val', $token );
					update_option( 'tdprb-access-token-data', $responses['data'] );
					$json['status'] = true;
					$json['message'] = 'Activated';
				} else {
					update_option( 'tdprb-access-token', 0 );
					update_option( 'tdprb-access-token-val', '' );
					update_option( 'tdprb-access-token-data', '' );
					$json['status'] = false;
					$json['message'] = isset($responses['message']) ? $responses['message'] : 'Activation failed';
				}
				wp_send_json($json);
				return;
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Token missing';
			wp_send_json($json);
			return;
		}
	}
	
	/**
	 * Ajax callback to deactivate token.
	 *
	 * @since    1.0.0
	 * @return void
	 */
	public function tdprb_token_deactivate_callback() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce(  sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-admin-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}
	
		// Deactivate the token
		update_option( 'tdprb-access-token', 0 );
		update_option( 'tdprb-access-token-val', '' );
		update_option( 'tdprb-access-token-data', '' );
		
		$json['status'] = true;
			$json['message'] = 'Token deactivated successfully';
			wp_send_json($json);
	}

	/**
	 * Render the general settings page.
	 *
	 * @since    1.0.0
	 */
	public function tdprb_general_settings_page() {
		if ( get_option('tdprb-access-token-val') != '' ) {
			include_once 'includes/settings/class-tdprb-general-setting.php';
			$settings = new TDPRB_General_Settings();
			$settings->render();
		}else{
			include_once TDPRB_DIR_PATH . '/admin/partials/tdprb-admin-display.php';
		}
    }

	/**
	 * Render the lab settings page.
	 *
	 * @since    1.0.0
	 */
	public function lab_settings_page() {
        include_once 'includes/settings/class-tdprb-lab-setting.php';
        $settings = new TDPRB_Lab_Settings();
        $settings->render();
    }

    /**
	 * Render the natural settings page.
	 *
	 * @since    1.0.0
	 */
    public function natural_settings_page() {
        require_once 'includes/settings/class-tdprb-natural-setting.php';
        $settings = new TDPRB_Natural_Settings();
        $settings->render();
    }

    /**
	 * Render the ring settings page.
	 *
	 * @since    1.0.0
	 */
    public function ring_settings_page() {
        require_once 'includes/settings/class-tdprb-ring-setting.php';
        $settings = new TDPRB_Ring_Settings();
        $settings->render();
    }

	 /**
	 * Render the ring settings page.
	 *
	 * @since    1.0.0
	 */
    public function orders_settings_page() {
        require_once 'includes/settings/class-tdprb-orders-setting.php';
        $settings = new TDPRB_Orders_List_Table();
        $settings->render();
    }

	/**
	 * Register the general settings.
	 *
	 * @since    1.0.0
	 */
	public function register_general_settings() {
		include_once 'includes/settings/class-tdprb-general-setting.php';
		$general_settings = new TDPRB_General_Settings();
		$general_settings->register();
	}

	/**
	 * Register the lab settings.
	 *
	 * @since    1.0.0
	 */
	public function register_lab_settings() {
		include_once 'includes/settings/class-tdprb-lab-setting.php';
		$lab_settings = new TDPRB_Lab_Settings();
		$lab_settings->register();
	}
	
	/**
	 * Register the natural settings.
	 *
	 * @since    1.0.0
	 */
	public function register_natural_settings() {
		include_once 'includes/settings/class-tdprb-natural-setting.php';
		$natural_settings = new TDPRB_Natural_Settings();
		$natural_settings->register();
	}

	/**
	 * Register the ring settings.
	 *
	 * @since    1.0.0
	 */
	public function register_ring_settings() {
		include_once 'includes/settings/class-tdprb-ring-setting.php';
		$ring_settings = new TDPRB_Ring_Settings();
		$ring_settings->register();
	}

	/**
	 * Capitalize the first letter of each word in a string.
	 *
	 * @since    1.0.0
	 * @param string $string The input string.
	 * @return string The capitalized string.
	 */
	function capitalizeFirstWordEachWord($string) {
		$words = explode(' ', $string);
		$capitalizedWords = array_map('ucfirst', $words);
		$capitalizedString = implode(' ', $capitalizedWords);
		return $capitalizedString;
	}

	/**
	 * Convert a string to an ID.
	 *
	 * @since    1.0.0
	 * @param string $string The input string.
	 * @return string The converted string.
	 */
	function convertToId($string) {
		// Remove all non-alphanumeric characters except for spaces
		$string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
		// Replace spaces with nothing (remove spaces)
		$string = str_replace(' ', '', $string);
		// Convert the string to lowercase
		$string = strtolower($string);
		
		return $string;
	}
}