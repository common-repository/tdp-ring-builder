<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://thediamondport.com/
 * @since      1.0.0
 *
 * @package    TDP_Ring_Builder
 * @subpackage TDP_Ring_Builder/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    TDP_Ring_Builder
 * @subpackage TDP_Ring_Builder/public
 * @author     TDP <tdp@gmail.com>
 */
class TDPRB_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
     * Check if a shortcode is present in the post content.
     *
     * @param string $shortcode The shortcode to check.
     * @return bool Whether the shortcode is present in the post content.
     */
    private function tdprb_is_shortcode_present( $shortcode ) {
        global $post;

        if ( ! $post ) {
            return false;
        }

        // Check if the shortcode exists in the post content
        if ( stripos( $post->post_content, '[' . $shortcode ) !== false ) {
            return true;
        }

        return false;
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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
		if ( $this->tdprb_is_shortcode_present( 'Ring_Builder' ) || get_query_var( 'custom_page' ) ) {
			// wp_enqueue_style( $this->plugin_name . '-index_css', plugin_dir_url( __FILE__ ) . 'vue-vite-app/dist/index.css', array(), $this->version );
			wp_enqueue_style( $this->plugin_name , plugin_dir_url( __FILE__ ) . 'css/tdprb-public.css', array(), $this->version );

			$options = get_option( 'tdprb_settings' );
		
			// Check if 'inline_css' is set and has a value
			if ( isset( $options['inline_css']['value'] ) ) {
				$custom_css = $options['inline_css']['value'];
				
				// Escape inline CSS before adding it to the page
				$custom_css = wp_kses( $custom_css, array( '\'', '\"', '>', '<', '{', '}', ':', ';' ) );
			
				// If the CSS is not empty after sanitization, echo it
				if ( $this->tdprb_is_shortcode_present( 'Ring_Builder' ) || get_query_var( 'custom_page' ) ) {
					if ( !empty( $custom_css ) ) {
						wp_add_inline_style( $this->plugin_name, wp_strip_all_tags( $custom_css ) );
					}
				}
			}
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		if ( $this->tdprb_is_shortcode_present( 'Ring_Builder' ) || get_query_var( 'custom_page' ) ) {
			// Enqueue scripts only if the shortcode is present
			$args = array(
				'in_footer' => true,
				'strategy' => 'defer',
			);
			// Enqueue your custom JavaScript
			wp_enqueue_script( $this->plugin_name . '-index_js', plugin_dir_url( __FILE__ ) . 'vue-vite-app/dist/index.js', array(), $this->version, $args );
			wp_localize_script(
				$this->plugin_name. '-index_js',
				'tdprbajax',
				array(
					'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
					'nonce' 			=> wp_create_nonce( 'tdprb-ajax-nonce' ),
				)
			);
		}
	}

	/**
	 * Template for the Ring Builder
	 *
	 * @param array $atts Shortcode attributes.
     * @return string
	 */
	public function tdprb_callback( $atts ) {
		ob_start();
		
		if( get_option('tdprb-access-token-val') != '' ) {
			?>
				<!-- vue app  -->
				<div id='tdp-rb'></div>
			<?php
		}
		return ob_get_clean();
	}

	/**
     * Register API endpoints.
     */
    public function tdprb_register_api_endpoints() {
        register_rest_route('tdp-rb/v1', '/front-data', array(
            'methods'  => 'GET',
            'callback' => array($this, 'tdprb_get_front_settings_data'),
            'permission_callback' => '__return_true', // Adjust permissions as needed
        ));
    }

	/**
     * Callback function to retrieve settings.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
	public function tdprb_get_front_settings_data(){
		$settings = array(
			'general_settings' 		=> 	$this->tdprb_get_settings(),
			'labgrown_settings' 	=>  $this->tdprb_get_lab_settings(),
			'natural_settings' 		=>  $this->tdprb_get_natural_settings(),
			'ring_settings' 		=>  $this->tdprb_get_ring_settings(),
		);
        $response = new WP_REST_Response($settings);
        $response->set_status(200);
        return $response;
	}

	/**
     * Callback function to retrieve settings.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function tdprb_get_settings() {
		$settingsData = get_option('tdprb_settings');
		if ($settingsData === false) {
			include_once TDPRB_DIR_PATH . '/admin/includes/settings/class-tdprb-general-setting.php';
			$settings = new TDPRB_General_Settings();
			$settingsData = $settings->defaultGenralSetting();
		}
		return $settingsData;
    }

	/**
     * Callback function to retrieve settings.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function tdprb_get_lab_settings() {
		$settingsData = get_option('tdprb_lab_settings');
		if ($settingsData === false) {
			include_once TDPRB_DIR_PATH . '/admin/includes/settings/class-tdprb-lab-setting.php';
			$settings = new TDPRB_Lab_Settings();
			$settingsData = $settings->defaultLabSetting();
		}
		return $settingsData;
    }

	/**
     * Callback function to retrieve settings.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function tdprb_get_natural_settings() {
		$settingsData = get_option('tdprb_natural_settings');
		if ($settingsData === false) {
			include_once TDPRB_DIR_PATH . '/admin/includes/settings/class-tdprb-natural-setting.php';
			$settings = new TDPRB_Natural_Settings();
			$settingsData = $settings->defaultNaturalSetting();
		}
		return $settingsData;
    }

	/**
     * Callback function to retrieve settings.
     *
     * @param WP_REST_Request $request
     * @return WP_REST_Response
     */
    public function tdprb_get_ring_settings() {
		$settingsData = get_option('tdprb_ring_settings');
		if ($settingsData === false) {
			include_once TDPRB_DIR_PATH . '/admin/includes/settings/class-tdprb-ring-setting.php';
			$settings = new TDPRB_Ring_Settings();
			$settingsData = $settings->defaultRingSetting();
		}
		return $settingsData;
    }

	/**
	 * Register custom slug
	 *
	 * @return void
	 */
	public function tdprb_register_custom_rewrite_rules() {
		add_rewrite_rule(
			'^([a-zA-Z0-9_-]+)/diamond-list/?$',
			'index.php?custom_page=diamond-list&parent_page=$matches[1]',
			'top'
		);
		add_rewrite_rule(
			'^([a-zA-Z0-9_-]+)/settings/?$',
			'index.php?custom_page=settings&parent_page=$matches[1]',
			'top'
		);
		add_rewrite_rule(
			'^([a-zA-Z0-9_-]+)/complete-ring/?$',
			'index.php?custom_page=complete-ring&parent_page=$matches[1]',
			'top'
		);
		add_rewrite_rule(
			'^([a-zA-Z0-9_-]+)/setting-details/([a-zA-Z0-9_-]+)/?$',
			'index.php?custom_page=setting-details&parent_page=$matches[1]&setting_id=$matches[2]',
			'top'
		);
		add_rewrite_rule(
			'^([a-zA-Z0-9_-]+)/diamond-details/([a-zA-Z]+)/([a-zA-Z0-9_-]+)/?$',
			'index.php?custom_page=diamond-details&parent_page=$matches[1]&type=$matches[2]&diamond_id=$matches[3]',
			'top'
		);
	}

	/**
	 * Map custom slug
	 *
	 * @param [type] $vars
	 * @return Object
	 */
	public function tdprb_add_custom_query_vars($vars) {
		$vars[] = 'custom_page';
		$vars[] = 'parent_page';
		$vars[] = 'setting_id';
		$vars[] = 'type';
		$vars[] = 'diamond_id';
		return $vars;
	}
	/**
	 * Inlcude Vue app Template
	 *
	 * @param [type] $template
	 * @return array object
	 */
	public function tdprb_handle_custom_template($template) {
		if (get_query_var('custom_page')) {
			$new_template = TDPRB_DIR_PATH . '/public/templates/vue-app-template.php';
			if (file_exists($new_template)) {
				return  $new_template;
			}
		}
		return $template;
	}

	/**
	 * Debug custom rewrite rules
	 *
	 * @return void
	 */
	function tdprb_debug_custom_rewrite_rules() {
		
		global $wp_rewrite;
		// echo '<pre>';
		// print_R(get_query_var('custom_page'));
		// print_r($wp_rewrite->rules);
		// echo '</pre>';
		// die();
	}

	/**
	 * Callback for the Get Diamond list
	 *
	 * @return object
	 */
	public function tdprb_diamond_list_ajax_callback(){
		$json = array();

		// Verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}

		// Sanitize input data
		$price 						= ! empty( $_POST['price'] ) 						? sanitize_text_field( wp_unslash( $_POST['price'] ) ) 				: '';
		$shape 						= ! empty( $_POST['shape'] ) 						? sanitize_text_field( wp_unslash($_POST['shape'] ) ) 				: '';
		$diamond_type 				= ! empty( $_POST['diamond_type'] ) 				? sanitize_text_field( wp_unslash($_POST['diamond_type'] ) ) 		: 'NATURAL';
		$fancy_color 				= ! empty( $_POST['fancy_color'] ) 					? sanitize_text_field( wp_unslash($_POST['fancy_color'] ) ) 		: '';
		$fancy_color_intensity 		= ! empty( $_POST['fancy_intensity'] ) 				? sanitize_text_field( wp_unslash($_POST['fancy_intensity'] ) ) 	: '';
		$carat 						= ! empty( $_POST['carats'] ) 						? sanitize_text_field( wp_unslash($_POST['carats'] ) ) 				: '';
		$color 						= ! empty( $_POST['color'] ) 						? sanitize_text_field( wp_unslash($_POST['color'] ) ) 				: '';
		$clarity 					= ! empty( $_POST['clarity'] ) 						? sanitize_text_field( wp_unslash($_POST['clarity'] ) ) 			: '';
		$cut 						= ! empty( $_POST['cut'] ) 							? sanitize_text_field( wp_unslash($_POST['cut'] ) ) 				: '';
		$polish 					= ! empty( $_POST['polish'] ) 						? sanitize_text_field( wp_unslash($_POST['polish'] ) ) 				: '';
		$symmetry 					= ! empty( $_POST['symmetry'] ) 					? sanitize_text_field( wp_unslash($_POST['symmetry'] ) ) 			: '';
		$fluorescence 				= ! empty( $_POST['fluorescence'] ) 				? sanitize_text_field( wp_unslash($_POST['fluorescence'] ) ) 		: '';
		$lab 						= ! empty( $_POST['lab'] ) 							? sanitize_text_field( wp_unslash($_POST['lab'] ) ) 				: '';
		$table 						= ! empty( $_POST['table_pr'] ) 					? sanitize_text_field( wp_unslash($_POST['table_pr'] ) ) 			: '';
		$depth 						= ! empty( $_POST['depth_pr'] ) 					? sanitize_text_field( wp_unslash($_POST['depth_pr'] ) ) 			: '';
		$ratio 						= ! empty( $_POST['l_w_ratio'] ) 					? sanitize_text_field( wp_unslash($_POST['l_w_ratio'] ) ) 			: '';
		$perpage 					= ! empty( $_POST['per_page'] ) 					? sanitize_text_field( wp_unslash($_POST['per_page'] ) ) 			: '';
		$is_image 					= ! empty( $_POST['is_image'] ) 					? sanitize_text_field( wp_unslash($_POST['is_image'] ) ) 			: '';
		$is_video 					= ! empty( $_POST['is_video'] ) 					? sanitize_text_field( wp_unslash($_POST['is_video'] ) ) 			: '';
		$page 						= ! empty( $_POST['page'] ) 						? sanitize_text_field( wp_unslash($_POST['page'] ) ) 				: '';

		// Determine sort order and field
		$sort_field = '';
		$sort_order = '';
		if ( isset( $_POST['sort_field'] ) ) {
			switch ( intval( $_POST['sort_field'] ) ) {
				case 1:
					$sort_field = '';
					$sort_order = '';
					break;
				case 2:
					$sort_field = 'price';
					$sort_order = 'asc';
					break;
				case 3:
					$sort_field = 'price';
					$sort_order = 'desc';
					break;
			}
		}

		// Prepare the request body
		$body = array(
			'token' 				=> TDPRB_ACCESS_TOKEN,
			'diamond_type' 			=> $diamond_type,
			'shape' 				=> $shape,
			'price' 				=> $price,
			'carat_size' 			=> $carat,
			'color' 				=> $color,
			'fancy_color' 			=> $fancy_color,
			'clarity' 				=> $clarity,
			'cut' 					=> $cut,
			'polish' 				=> $polish,
			'symmetry' 				=> $symmetry,
			'fluorescence' 			=> $fluorescence,
			'lab' 					=> $lab,
			'table' 				=> $table,
			'depth' 				=> $depth,
			'lwratio' 				=> $ratio,
			'perpage' 				=> $perpage,
			'sort_order' 			=> $sort_order,
			'sort_field' 			=> $sort_field
		);

		// Make the remote request
		$response = wp_remote_post( TDPRB_DIAMOND_SEARCH_API . $page, array(
			'body' 			=> $body,
			'timeout' 		=> 120,
			'redirection' 	=> 5,
			'httpversion' 	=> '1.1',
			'blocking' 		=> true,
			'headers' 		=> array(),
			'cookies' 		=> array(),
			'sslverify' 	=> false, // Only use this option if you're certain the API endpoint is trustworthy and necessary
		));
	
		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => $response->get_error_message() ) );
		} else {
			$data = json_decode( wp_remote_retrieve_body( $response ), true );
			wp_send_json_success( $data );			
		}

	}

	/**
	 * Callback for the Get Diamond Details
	 *
	 * @return object
	 */
	public function tdprb_diamond_details_ajax_callback(){
		$json = array();


		// Verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}

		// Sanitize input data
		$diamond_type = ! empty( $_POST['diamond_type'] ) 	? sanitize_text_field( wp_unslash( $_POST['diamond_type'] ) ) : 'NATURAL';
		$sku 		  = ! empty( $_POST['sku'] ) 			? sanitize_text_field( wp_unslash( $_POST['sku'] ) ) 		  : '';

		// Prepare the request body
		$body = array(
			'token' 				=> TDPRB_ACCESS_TOKEN,
			'diamond_type' 			=> $diamond_type,
			'sku' 					=> $sku,
		);

		// Make the remote request
		$response = wp_remote_post( TDPRB_DIAMOND_SINGLE_SEARCH_API, array(
			'body' 			=> $body,
			'timeout' 		=> 120,
			'redirection' 	=> 5,
			'httpversion' 	=> '1.1',
			'blocking' 		=> true,
			'headers' 		=> array(),
			'cookies' 		=> array(),
			'sslverify' 	=> false, // Only use this option if you're certain the API endpoint is trustworthy and necessary
		));
	
		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => $response->get_error_message() ) );
		} else {
			$data = json_decode( wp_remote_retrieve_body( $response ), true );
			wp_send_json_success( $data );			
		}

	}

	/**
	 * Callback for the Rings list
	 *
	 * @return object
	 */
	public function tdprb_rings_list_ajax_callback(){
		$json = array();

		// Verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}

		// Sanitize input data
		$category 		= ! empty( $_POST['category'] ) 		? sanitize_text_field( wp_unslash( $_POST['category'] ) )	: '';
		$sub_category	= ! empty( $_POST['sub_category'] ) 	? sanitize_text_field( wp_unslash( $_POST['sub_category'] ) )  : '';
		$metal 			= ! empty( $_POST['metal'] ) 			? sanitize_text_field( wp_unslash( $_POST['metal'] ) )		: '';
		$shape 			= ! empty( $_POST['shape'] ) 			? sanitize_text_field( wp_unslash( $_POST['shape'] ) )		: '';
		$price 			= ! empty( $_POST['price'] ) 			? sanitize_text_field( wp_unslash( $_POST['price'] ) )		: '';
		$perpage 		= ! empty( $_POST['per_page'] ) 		? sanitize_text_field( wp_unslash( $_POST['per_page'] ) )	: '';
		$is_image 		= ! empty( $_POST['is_image'] ) 		? sanitize_text_field( wp_unslash( $_POST['is_image'] ) )	: '';
		$page 			= ! empty( $_POST['page'] ) 			? sanitize_text_field( wp_unslash( $_POST['page'] ) )		: '';

		// Determine sort order and field
		$sort_field = '';
		$sort_order = '';
		if ( isset( $_POST['sort_field'] ) ) {
			switch ( intval( $_POST['sort_field'] ) ) {
				case 1:
					$sort_field = '';
					$sort_order = '';
					break;
				case 2:
					$sort_field = 'price';
					$sort_order = 'asc';
					break;
				case 3:
					$sort_field = 'price';
					$sort_order = 'desc';
					break;
			}
		}

		// Prepare the request body
		$body = array(
			'token' 				=> TDPRB_ACCESS_TOKEN,
			'category' 				=> $category,
			'sub_category' 			=> $sub_category,
			'metal' 				=> $metal,
			'price' 				=> $price,
			'perpage' 				=> $perpage,
			'sort_order' 			=> $sort_order,
			'sort_field' 			=> $sort_field
		);

		// Make the remote request
		$response = wp_remote_post( TDPRB_RINGS_SEARCH_API . $page, array(
			'body' 			=> $body,
			'timeout' 		=> 120,
			'redirection' 	=> 5,
			'httpversion' 	=> '1.1',
			'blocking' 		=> true,
			'headers' 		=> array(),
			'cookies' 		=> array(),
			'sslverify' 	=> false, // Only use this option if you're certain the API endpoint is trustworthy and necessary
		));
	
		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => $response->get_error_message() ) );
		} else {
			$data = json_decode( wp_remote_retrieve_body( $response ), true );
			wp_send_json_success( $data );			
		}

	}

	/**
	 * Callback for the Get Ring Details
	 *
	 * @return object
	 */
	public function tdprb_ring_details_ajax_callback(){
		$json = array();

		// Verify nonce
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}

		// Sanitize input data
		$sku = ! empty( $_POST['sku'] ) ? sanitize_text_field( wp_unslash( $_POST['sku'] ) ): '';
		
		// Prepare the request body
		$body = array(
			'token' 				=> TDPRB_ACCESS_TOKEN,
			'sku' 					=> $sku,
		);

		// Make the remote request
		$response = wp_remote_post( TDPRB_RING_SINGLE_SEARCH_API, array(
			'body' 			=> $body,
			'timeout' 		=> 120,
			'redirection' 	=> 5,
			'httpversion' 	=> '1.1',
			'blocking' 		=> true,
			'headers' 		=> array(),
			'cookies' 		=> array(),
			'sslverify' 	=> false, // Only use this option if you're certain the API endpoint is trustworthy and necessary
		));
	
		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array( 'message' => $response->get_error_message() ) );
		} else {
			$data = json_decode( wp_remote_retrieve_body( $response ), true );
			wp_send_json_success( $data );			
		}
	}

	/**
	 * Sanitize request data
	 *
	 * @param [type] $data
	 * @return void
	 */
	 private function tdprb_sanitize_data($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = $this->tdprb_sanitize_data($value); // Recursively sanitize each element
			}
		} else {
			// Sanitize based on the expected data type
			$data = sanitize_text_field($data); // Adjust this to the correct sanitizer if you expect different data types
		}
		return $data;
	}

	/**
	 * Loose Diamond Add to cart callback
	 *
	 * @return object
	 */
	public function tdprb_loosediamond_add_to_cart_callback() {
		$json = array();
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}
		
		// Validate the data
		$diamond_data = isset($_POST['diamondData']) ? sanitize_text_field( wp_unslash( $_POST['diamondData'] ) ) : array();
		if (isset($diamond_data) && !empty($diamond_data)) {
			$diamond_data = json_decode(stripslashes($diamond_data), true);
			
			$diamond_data = $this->tdprb_sanitize_data($diamond_data);
			// Ensure the data is an array
			if (!is_array($diamond_data)) {
				$json['status'] = false;
				$json['message'] = 'Invalid diamond data format';
				wp_send_json($json);
			}

			// Check if product is already in cart
			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
				if ($cart_item['data']->get_sku() == $diamond_data['certificate_no']) {
					$json['status'] = false;
					$json['message'] = 'Product is already in the cart';
					wp_send_json($json);
				}
			}
			$productURL = !empty( $diamond_data['productURL'] ) ? $diamond_data['productURL'] : '';
			$attributes = array(
				'diamond_type' 		=> $diamond_data['diamond_type'],
				'diamond_sku'		=> $diamond_data['sku'],
				'shape' 			=> $diamond_data['shape'],
				'carat' 			=> $diamond_data['carat'],
				'color' 			=> $diamond_data['color'],
				'clarity' 			=> $diamond_data['clarity'],
				'cut' 				=> $diamond_data['cut'],
				'polish' 			=> $diamond_data['polish'],
				'symmetry' 			=> $diamond_data['symmetry'],
				'fluorescence' 		=> $diamond_data['fluorescence'],
				'lab' 				=> $diamond_data['lab'],
				'certificate_no' 	=> $diamond_data['certificate_no'],
				'country' 			=> $diamond_data['country'],
				'crown_angle' 		=> $diamond_data['crown_angle'],
				'crown_height' 		=> $diamond_data['crown_height'],
				'pavilion_angle' 	=> $diamond_data['pavilion_angle'],
				'pavilion_depth' 	=> $diamond_data['pavilion_depth'],
				'shade' 			=> $diamond_data['shade'],
				'productURL'		=> $productURL
			);

			// Check if product exists in WooCommerce and its stock status
			$product_id = wc_get_product_id_by_sku($diamond_data['certificate_no']);
			if ($product_id) {
				$product = wc_get_product($product_id);
				if (!$product->is_in_stock()) {
					$json['status'] = false;
					$json['message'] = 'Product is out of stock';
					wp_send_json($json);
				}
			}else {
				
				// Create the WooCommerce product
				$product = new WC_Product_Simple();
				$product->set_name($diamond_data['diamondTitle']);
				$product->set_regular_price($diamond_data['price']);
				$product->set_sku($diamond_data['certificate_no']);
				$product->set_manage_stock(TRUE); //Set if product manage stock.    
				$product->set_stock_quantity(1); // Set stock quantity to 1
				$product->set_stock_status('instock');
				$product->set_catalog_visibility('visible');
				
				// Set product image
				if (!empty($diamond_data['image'])) {
					$image_url = $diamond_data['image'];
					// Download image to the media library
					$image_id = media_sideload_image($image_url, 0, '', 'id');
					if (!is_wp_error($image_id)) {
						$product->set_image_id($image_id);
					}
				} else {
					// Set default image based on shape
					$shape = strtolower($diamond_data['shape']);
					$default_image_id = $this->tdprb_get_or_upload_default_image($shape);
					if ($default_image_id) {
						$product->set_image_id($default_image_id);
					}
				}

				 // Check if category exists, create it if it doesn't
				 $category_name = ( $diamond_data['diamond_type'] == 'L' ) ? 'Lab Loosediamond' : 'Natural Loosediamond' ;
				 $category = get_term_by('name', $category_name, 'product_cat');
				 if (!$category) {
					 $category_id = wp_insert_term($category_name, 'product_cat');
					 if (is_wp_error($category_id)) {
						 $json['status'] = false;
						 $json['message'] = 'Failed to create product category';
						 wp_send_json($json);
					 }
					 $category_id = $category_id['term_id'];
				 } else {
					 $category_id = $category->term_id;
				 }
	 
				// Save the product
				$product_id = $product->save();
				 
				// Set product category
				wp_set_object_terms($product_id, $category_id, 'product_cat');
				  // Store a custom meta key to indicate this is an API product
    			update_post_meta( $product_id, '_is_custom_tdp_product', 'yes');
				update_post_meta($product_id, 'diamond_sku', $diamond_data['sku']);
			
			}
			if ($product_id) {

				WC()->cart->add_to_cart($product_id, 1, 0, array(), array( 'tdprb_product_type' => 'loose_diamond', 'tdprb_product_attributes' => $attributes ) );

				$json['status'] = true;
				$json['message'] = 'Product added to cart successfully';
				$json['product_id'] = $product_id;
				$json['cart_url'] = wc_get_cart_url();
				
			} else {
				$json['status'] = false;
				$json['message'] = 'Failed to create product';
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Invalid or empty diamond data';
		}
		wp_send_json($json);
	}

	/**
	 * Loose Ring Add to cart callback
	 *
	 * @return object
	 */
	public function tdprb_loosering_add_to_cart_callback() {
		$json = array();
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}

		// Validate the data
		$ring_data = isset($_POST['settingData']) ?	sanitize_text_field( wp_unslash( $_POST['settingData'] ) ): array();
		if (isset($ring_data) && !empty($ring_data)) {
			$ring_data = json_decode(stripslashes($ring_data), true);
			$ring_data = $this->tdprb_sanitize_data($ring_data);
			// Ensure the data is an array
			if (!is_array($ring_data)) {
				$json['status'] = false;
				$json['message'] = 'Invalid ring data format';
				wp_send_json($json);
			}

			// Check if product is already in cart
			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
				if ($cart_item['data']->get_sku() == $ring_data['sku']) {
					$json['status'] = false;
					$json['message'] = 'Product is already in the cart';
					wp_send_json($json);
				}
			}

			$productURL = !empty( $ring_data['productURL'] ) ? $ring_data['productURL'] : '';
			$attributes = array(
				'category'            => $ring_data['category'],
				'sub_category'        => $ring_data['sub_category'],
				'setting_sku'         => $ring_data['sku'],
				'selectedMetal'       => $ring_data['selectedMetal'],
				'selectedRingSize'    => $ring_data['selectedRingSize'],
				'shipping_days'       => $ring_data['shipping_days'],
				'productURL'          => $productURL
			);

			// Check if product exists in WooCommerce and its stock status
			$product_id = wc_get_product_id_by_sku($ring_data['sku']);
			if ($product_id) {
				$product = wc_get_product($product_id);
				if (!$product->is_in_stock()) {
					$json['status'] = false;
					$json['message'] = 'Product is out of stock';
					wp_send_json($json);
				}
			}else {
				
				// Create the WooCommerce product
				$product = new WC_Product_Simple();
				$product->set_name($ring_data['product_name']);
				$product->set_regular_price($ring_data['total_price']);
				$product->set_description($ring_data['product_description']);
				$product->set_sku($ring_data['sku']);
				$product->set_manage_stock(TRUE); //Set if product manage stock.    
				$product->set_stock_quantity(10); // Set stock quantity to 1
				$product->set_stock_status('instock');
				$product->set_catalog_visibility('visible');
				
				// Set product image
				if (!empty($ring_data['main_image'])) {
					$image_url = $ring_data['main_image'];
					// Download image to the media library
					$image_id = media_sideload_image($image_url, 0, '', 'id');
					if (!is_wp_error($image_id)) {
						$product->set_image_id($image_id);
					}
				}

				 // Check if category exists, create it if it doesn't
				 $category_name = ( $ring_data['category'] == 'ring' ) ? 'Loose Ring' : '' ;
				 $category = get_term_by('name', $category_name, 'product_cat');
				 if (!$category) {
					 $category_id = wp_insert_term($category_name, 'product_cat');
					 if (is_wp_error($category_id)) {
						 $json['status'] = false;
						 $json['message'] = 'Failed to create product category';
						 wp_send_json($json);
					 }
					 $category_id = $category_id['term_id'];
				 } else {
					 $category_id = $category->term_id;
				 }
	 
				// Save the product
				$product_id = $product->save();
				 
				// Set product category
				wp_set_object_terms($product_id, $category_id, 'product_cat');
				  // Store a custom meta key to indicate this is an API product
    			update_post_meta( $product_id, '_is_custom_tdp_product', 'yes');
			
			}
			if ($product_id) {
				
				WC()->cart->add_to_cart($product_id, 1, 0, array(), array( 'tdprb_product_type' => 'loose_ring', 'tdprb_product_attributes' => $attributes ) );

				$json['status'] = true;
				$json['message'] = 'Product added to cart successfully';
				$json['product_id'] = $product_id;
				$json['cart_url'] = wc_get_cart_url();
				
			} else {
				$json['status'] = false;
				$json['message'] = 'Failed to create product';
			}
		} else {
			$json['status'] = false;
			$json['message'] = 'Invalid or empty Ring data';
		}
		wp_send_json($json);
	}

	/**
	 * Function to check if product is already in cart
	 *
	 * @param [type] $sku
	 * @return boolean
	 */
	private function tdprb_is_product_in_cart($sku) {
		foreach (WC()->cart->get_cart() as $cart_item) {
			if ($cart_item['data']->get_sku() === $sku) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Get or create Diamond Product
	 *
	 * @param [type] $diamond_data
	 * @return object
	 */
	private function tdprb_get_or_create_diamond_product($diamond_data) {
		
		$product_id = wc_get_product_id_by_sku($diamond_data['certificate_no']);
		$attributes = array(
			'diamond_type'      => $diamond_data['diamond_type'],
			'diamond_sku'       => $diamond_data['sku'],
			'shape'             => $diamond_data['shape'],
			'carat'             => $diamond_data['carat'],
			'color'             => $diamond_data['color'],
			'clarity'           => $diamond_data['clarity'],
			'cut'               => $diamond_data['cut'],
			'polish'            => $diamond_data['polish'],
			'symmetry'          => $diamond_data['symmetry'],
			'fluorescence'      => $diamond_data['fluorescence'],
			'lab'               => $diamond_data['lab'],
			'certificate_no'    => $diamond_data['certificate_no'],
			'country'           => $diamond_data['country'],
			'crown_angle'       => $diamond_data['crown_angle'],
			'crown_height'      => $diamond_data['crown_height'],
			'pavilion_angle'    => $diamond_data['pavilion_angle'],
			'pavilion_depth'    => $diamond_data['pavilion_depth'],
			'shade'             => $diamond_data['shade'],
			'productURL'        => !empty($diamond_data['productURL']) ? $diamond_data['productURL'] : ''
		);
		
		if ($product_id) {
			$product = wc_get_product($product_id);
			
			// Check if the product is in stock
			if (!$product->is_in_stock()) {
				return new WP_Error('out_of_stock', 'The selected diamond is out of stock.');
			}
			
			return array('product' => wc_get_product($product_id), 'attributes' => $attributes);
		}
		
		// Create a new diamond product
		$product = new WC_Product_Simple();
		$product->set_name($diamond_data['title']);
		$product->set_regular_price($diamond_data['price']);
		$product->set_sku($diamond_data['certificate_no']);
		$product->set_manage_stock(TRUE);
		$product->set_stock_quantity(1);
		$product->set_stock_status('instock');
		$product->set_catalog_visibility('visible');

		// Set product image
		if (!empty($diamond_data['image'])) {
			$image_url = esc_url_raw($diamond_data['image']);
			$image_id = media_sideload_image($image_url, 0, '', 'id');
			if (!is_wp_error($image_id)) {
				$product->set_image_id($image_id);
			} else {
				return new WP_Error('image_error', 'Failed to add diamond image.');
			}
		} else {
			// Set default image based on shape
			$shape = strtolower($diamond_data['shape']);
			$default_image_id = $this->tdprb_get_or_upload_default_image($shape);
			if ($default_image_id) {
				$product->set_image_id($default_image_id);
			}
		}
		
		// Check if category exists, create it if it doesn't
		$category_name = ($diamond_data['diamond_type'] === 'L') ? 'Lab Loosediamond' : 'Natural Loosediamond';
		$category = get_term_by('name', $category_name, 'product_cat');
		if (!$category) {
			$category_id = wp_insert_term($category_name, 'product_cat');
			if (is_wp_error($category_id)) {
				return new WP_Error('category_error', 'Failed to create product category.');
			}
			$category_id = $category_id['term_id'];
		} else {
			$category_id = $category->term_id;
		}
	
		// Save the product
		$product_id = $product->save();
		if (!$product_id) {
			return new WP_Error('product_creation_error', 'Failed to create diamond product.');
		}
	
		// Set product category
		wp_set_object_terms($product_id, $category_id, 'product_cat');
	
		// Store a custom meta key to indicate this is an API product
		update_post_meta($product_id, '_is_custom_tdp_product', 'yes');
		update_post_meta($product_id, 'diamond_sku', $diamond_data['sku']);
	
		return array('product' => wc_get_product($product_id), 'attributes' => $attributes);
	}

	/**
	 * Get or create Ring Data
	 *
	 * @param [type] $setting_data
	 * @return object
	 */
	private function tdprb_get_or_create_setting_product($setting_data) {
	
		$product_id = wc_get_product_id_by_sku($setting_data['sku']);
		$attributes = array(
			'category'            => $setting_data['category'],
			'sub_category'        => $setting_data['sub_category'],
			'setting_sku'         => $setting_data['sku'],
			'selectedMetal'       => $setting_data['selectedMetal'],
			'selectedRingSize'    => $setting_data['selectedRingSize'],
			'engravingTexts'      => $setting_data['engravingTexts'],
			'shipping_days'       => $setting_data['shipping_days'],
			'productURL'          => !empty($setting_data['productURL']) ? $setting_data['productURL'] : ''
		);
		if ($product_id) {
			$product = wc_get_product($product_id);
	
			// Check if the product is in stock
			if (!$product->is_in_stock()) {
				return new WP_Error('out_of_stock', 'The selected setting is out of stock.');
			}
	
			return array('product' => wc_get_product($product_id), 'attributes' => $attributes);
		}
		
		// Create the WooCommerce product
		$product = new WC_Product_Simple();
		$product->set_name($setting_data['product_name']);
		$product->set_regular_price($setting_data['total_price']);
		//$product->set_sale_price($setting_data['cprice']);
		$product->set_description($setting_data['product_description']);
		//$product->set_short_description('0.18 Carat, D Color, SI1 Clarity');
		$product->set_sku($setting_data['sku']);
		$product->set_manage_stock(TRUE); //Set if product manage stock.    
		$product->set_stock_quantity(10); // Set stock quantity to 1
		$product->set_stock_status('instock');
		$product->set_catalog_visibility('visible');
		
		// Set product image
		if (!empty($setting_data['main_image'])) {
			$image_id = media_sideload_image($setting_data['main_image'], 0, '', 'id');
			if (is_wp_error($image_id)) {
				return new WP_Error('image_error', 'Failed to add setting image.');
			}
			$product->set_image_id($image_id);
		}
	
		// Set product category
		$category_name = ( $setting_data['category'] == 'ring' ) ? 'Loose Ring' : '' ;
		$category = get_term_by('name', $category_name, 'product_cat');
		if (!$category) {
			$category_id = wp_insert_term($category_name, 'product_cat');
			if (is_wp_error($category_id)) {
				$json['status'] = false;
				$json['message'] = 'Failed to create product category';
				wp_send_json($json);
			}
			$category_id = $category_id['term_id'];
		} else {
			$category_id = $category->term_id;
		}

		// Save the product
		$product_id = $product->save();

		if (!$product_id) {
			return new WP_Error('product_creation_error', 'Failed to create setting product.');
		}
		// Set product category
		wp_set_object_terms($product_id, $category_id, 'product_cat');
		// Store a custom meta key to indicate this is an API product
	  	update_post_meta( $product_id, '_is_custom_tdp_product', 'yes');

		return array('product' => wc_get_product($product_id), 'attributes' => $attributes);
	}
	
	/**
	 * Complete Ring Add to cart callback
	 *
	 * @return object
	 */
	public function tdprb_completering_add_to_cart_callback() {
		
		
		$response = array();
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'tdprb-ajax-nonce' ) ) {
			$json['status'] = false;
			$json['message'] = 'Nonce missing or invalid';
			wp_send_json($json);
			return;
		}
	
		$complete_ring_data = isset($_POST['completeRingData']) ? sanitize_text_field( wp_unslash($_POST['completeRingData']) ) : [];
		$complete_ring_data = json_decode($complete_ring_data, true);
		if (empty($complete_ring_data['diamond']) || empty($complete_ring_data['setting'])) {
			$response['status'] = false;
			$response['message'] = 'Invalid or incomplete data provided.';
			wp_send_json($response);
		}
	
		$diamond_data = $this->tdprb_sanitize_data($complete_ring_data['diamond']);
		$setting_data = $this->tdprb_sanitize_data($complete_ring_data['setting']);
		
		// Initialize flags for product existence in the cart
		$diamond_in_cart = $this->tdprb_is_product_in_cart($diamond_data['certificate_no']);
		$setting_in_cart = $this->tdprb_is_product_in_cart($setting_data['sku']);
			

		// Check if both products are in the cart
		if ($diamond_in_cart && $setting_in_cart) {
			$response['status'] = false;
			$response['message'] = 'Both diamond and setting are already in the cart.';
			wp_send_json($response);
		}
		
		// Check if individual products are already in the cart
		if ($diamond_in_cart) {
			$response['status'] = false;
			$response['message'] = 'Diamond is already in the cart.';
			wp_send_json($response);
		}

		if ($setting_in_cart) {
			$response['status'] = false;
			$response['message'] = 'Setting is already in the cart.';
			wp_send_json($response);
		}

		// Create or get existing diamond product
		$diamond_product_data = $this->tdprb_get_or_create_diamond_product($diamond_data);
		
		if (is_wp_error($diamond_product_data)) {
			$response['status'] = false;
			$response['message'] = $diamond_product_data->get_error_message();
			wp_send_json($response);
		}
		

		// Create or get existing setting product
		$setting_product_data = $this->tdprb_get_or_create_setting_product($setting_data);
		if (is_wp_error($setting_product_data)) {
			$response['status'] = false;
			$response['message'] = $setting_product_data->get_error_message();
			wp_send_json($response);
		}
		$setting_product_data['attributes']['certificate_no'] = $diamond_product_data['attributes']['certificate_no'];
		// Add products to cart
		$added_diamond = WC()->cart->add_to_cart( $diamond_product_data['product']->get_id(), 1,0, array(), array( 'tdprb_product_type' => 'complete_setting', 'tdprb_product_attributes' => $diamond_product_data['attributes'] ) );
		$added_setting = WC()->cart->add_to_cart( $setting_product_data['product']->get_id(), 1,0, array(), array( 'tdprb_product_type' => 'complete_setting', 'tdprb_product_attributes' => $setting_product_data['attributes'] ) );

		// Check if both products were successfully added
		if (!$added_diamond || !$added_setting) {
			// Remove diamond from the cart if it was added and setting failed
			if ($added_diamond) {
				WC()->cart->remove_cart_item($added_diamond);
			}

			// Remove setting from the cart if it was added and diamond failed
			if ($added_setting) {
				WC()->cart->remove_cart_item($added_setting);
			}

			$response['status'] = false;
			$response['message'] = 'Failed to add complete ring to the cart.';
			wp_send_json($response);
		}

		$response['status'] = true;
		$response['message'] = 'Products added to cart successfully.';
		$response['cart_url'] = wc_get_cart_url();
		wp_send_json($response);
	}

	/**
	 * Get or upload default image by shape
	 *
	 * @param string $shape
	 * @return int|null
	 */
	public function tdprb_get_or_upload_default_image($shape) {
		// Map shapes to default image filenames (ensure these are uploaded to the media library)
		$shape_to_image = array(
			'asscher' 		=> 'asscher.svg',
			'cushion' 		=> 'cushion.svg',
			'emerald' 		=> 'emerald.svg',
			'heart' 		=> 'heart.svg',
			'marquise' 		=> 'marquise.svg',
			'oval' 			=> 'oval.svg',
			'pear' 			=> 'pear.svg',
			'princess' 		=> 'princess.svg',
			'radiant' 		=> 'radiant.svg',
			'baguette' 		=> 'baguette.svg',
			'briolette' 	=> 'briolette.svg',
			'bullet' 		=> 'bullet.svg',
			'calf' 			=> 'calf.svg',
			'cushionbri' 	=> 'cushionbri.svg',
			'cushionmod' 	=> 'cushionmod.svg',
			'europeanct' 	=> 'europeanct.svg',
			'flanders' 		=> 'flanders.svg',
			'halfmoon' 		=> 'halfmoon.svg',
			'heart' 		=> 'heart.svg',
			'kite' 			=> 'kite.svg',
			'octagonal' 	=> 'octagonal.svg',
			'oldminar' 		=> 'oldminar.svg',
			'other' 		=> 'other.svg',
			'pentagonal' 	=> 'pentagonal.svg',
			'shield' 		=> 'shield.svg',
			'sqradiant' 	=> 'sqradiant.svg',
			'square' 		=> 'square.svg',
			'star' 			=> 'star.svg',
			'taperedbag' 	=> 'taperedbag.svg',
			'taperedbul' 	=> 'taperedbul.svg',
			'trapezoid' 	=> 'trapezoid.svg',
			'triangular' 	=> 'triangular.svg',
			'trilliant' 	=> 'trilliant.svg',
		);

		if (array_key_exists($shape, $shape_to_image)) {
			$filename = $shape_to_image[$shape];
	
			// Check if the image is already in the media library
			$query = new WP_Query(array(
				'post_type' => 'attachment',
				'meta_query' => array(
					array(
						'key' => '_wp_attached_file',
						'value' => $filename,
						'compare' => '='
					)
				),
				'posts_per_page' => 1,
				'post_status' => 'inherit',
			));
	
			if ($query->have_posts()) {
				return $query->posts[0]->ID;
			} else {
				// Upload the default image
				$file_path = TDPRB_DIR_PATH . "/public/vue-vite-app/src/assets/images/{$filename}";
				if (file_exists($file_path)) {
					global $wp_filesystem;
	
					// Initialize WP_Filesystem
					if (empty($wp_filesystem)) {
						require_once ABSPATH . 'wp-admin/includes/file.php';
						WP_Filesystem();
					}
	
					$file_content = $wp_filesystem->get_contents($file_path);
					if ($file_content !== false) {
						$upload = wp_upload_bits($filename, null, $file_content);
						if (!$upload['error']) {
							$attachment = array(
								'guid' => $upload['url'],
								'post_mime_type' => 'image/svg+xml',
								'post_title' => sanitize_file_name($filename),
								'post_content' => '',
								'post_status' => 'inherit'
							);
							$image_id = wp_insert_attachment($attachment, $upload['file']);
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata($image_id, $upload['file']);
							wp_update_attachment_metadata($image_id, $attach_data);
							return $image_id;
						}
					}
				}
			}
		}
		return null;
	}

	/**
	 * Display custom cart item data in cart
	 *
	 * @param [type] $item_data
	 * @param [type] $cart_item
	 * @return object
	 */
	function tdprb_display_custom_data_in_cart($item_data, $cart_item) {
		if (isset($cart_item['tdprb_product_attributes']) && isset($cart_item['tdprb_product_attributes']['certificate_no']) && isset($cart_item['tdprb_product_attributes']['diamond_type'] )) {
			$item_data[] = array(
				'name' => 'Certificate',
				'value' => $cart_item['tdprb_product_attributes']['certificate_no'],
			);
		}

		if (isset($cart_item['tdprb_product_attributes']) && isset($cart_item['tdprb_product_attributes']['selectedRingSize'])) {
			$item_data[] = array(
				'name' => 'Ring Size',
				'value' => $cart_item['tdprb_product_attributes']['selectedRingSize'],
			);
		}

		return $item_data;
	}
	/**
	 * Add custom cart item data to order item
	 *
	 * @param [type] $item
	 * @param [type] $cart_item_key
	 * @param [type] $values
	 * @param [type] $order
	 * @return void
	 */
	function tdprb_add_custom_data_to_order_item($item, $cart_item_key, $values, $order) {
		if (isset($values['tdprb_product_attributes'])) {
			$cart_data = $values['tdprb_product_attributes'];
			if (isset($values['tdprb_product_type'])) {
				switch ($values['tdprb_product_type']) {
					case 'loose_diamond':
						if (isset($cart_data['certificate_no'])) {
							$item->add_meta_data('Certificate No', $cart_data['certificate_no']);
						}
						$item->add_meta_data('Item', 'Loose Diamond');
						break;
					
					case 'loose_ring':
						if (isset($cart_data['selectedRingSize'])) {
							$item->add_meta_data('Ring Size', $cart_data['selectedRingSize']);
						}
						$item->add_meta_data('Item', 'Only Ring');
						break;
					
					case 'complete_setting':

						if (isset($cart_data['certificate_no'])) {
							$item->add_meta_data('Certificate No', $cart_data['certificate_no']);
						}
						if (isset($cart_data['engravingTexts'])) {
							$item->add_meta_data('Engraving Text', $cart_data['engravingTexts']);
						}
						if (isset($cart_data['selectedRingSize'])) {
							$item->add_meta_data('Ring Size', $cart_data['selectedRingSize']);
						}
						if( isset( $cart_data['diamond_type'] ) && $cart_data['diamond_type'] === 'W' || $cart_data['diamond_type'] === 'L' ){
							$item->add_meta_data('Item', 'Complete Diamond Setting');
						}else if( isset( $cart_data['category'] ) && $cart_data['category'] === 'ring' ){
							$item->add_meta_data('Item', 'Complete Ring Setting');
						}
						
						break;
				}
			}
		}
	}

	/**
	 * Custom URL for cart product
	 *
	 * @param [type] $permalink
	 * @param [type] $cart_item
	 * @param [type] $cart_item_key
	 * @return permalink
	 */
	public function tdprb_custom_cart_item_permalink( $permalink, $cart_item, $cart_item_key ) {
		// HERE your defined product category
		if (isset($cart_item['tdprb_product_attributes'])) {
			$cart_data = $cart_item['tdprb_product_attributes'];
			if (isset($cart_data['productURL']) && $cart_data['productURL'] != '') {
				$permalink = $cart_data['productURL'];
			}
		}
		return $permalink;
	}

	/**
	 * Allowed localhost domain
	 *
	 * @param [type] $origins
	 * @return void
	 */
	function add_allowed_origins($origins){
		$origins[] = 'http://localhost:5173';
		return $origins;
	}

	/**
	 * Called when an order is placed, making an API call.
	 *
	 * @param int $order_id The order ID.
	 * @return void
	 */
	public function tdprb_order_placed_api_call( $order_id ) {

		if ( ! $order_id ) {
			return;
		}

		// Get an instance of the WC_Order object	
		$order = wc_get_order( $order_id );

		// Allow code execution only once 
		if( ! $order->get_meta( '_thankyou_action_done', true ) ) {

			// Initialize WP_Filesystem
			global $wp_filesystem;
			if ( ! function_exists( 'WP_Filesystem' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}
			WP_Filesystem();

			$plugin_dir = TDPRB_DIR_PATH;
			$log_dir    = $plugin_dir . '/logs/';
			$log_file   = $log_dir . 'order_log.txt';

			// Ensure log directory exists
			if ( ! $wp_filesystem->is_dir( $log_dir ) ) {
				$wp_filesystem->mkdir( $log_dir, 0755 );
			}

			// Check if the log directory is writable
			if ( ! $wp_filesystem->is_writable( $log_dir ) ) {
				error_log( "Log directory is not writable: $log_dir" );
				return;
			}

			// Retrieve order items
			$order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
			$cnt = 0;
			$cnt_final = 0;
			foreach ( $order_items as $item_id => $item ) {

				$product = $item->get_product();
				$itemmeta = $item->get_meta( 'Item', true ); // Corrected to use 'Product Type' as the key

				// Prepare API request body
				$body['token'] = TDPRB_ACCESS_TOKEN;

				if ( $product && has_term( 'lab-loosdiamond', 'product_cat', $product->get_id() ) ) {
					$body['diamond_type'] = 'LABGROWN';
				} elseif ( $product && has_term( 'natural-loosediamond', 'product_cat', $product->get_id() ) ) {
					$body['diamond_type'] = 'NATURAL';
				}

				// Determine the product type and prepare the corresponding API data
				if ( $itemmeta === 'Loose Diamond' ) {
					$body['diamond_sku'] = get_post_meta( $product->get_id(), 'diamond_sku', true);
					$cnt++;
				} elseif ( $itemmeta === 'Only Ring' ) {
					$body['diamond_type'] 	= 'Ring';
					$body['diamond_sku']  	= $product->get_sku();
					$body['ring_sku'] 		= $product->get_sku();
					$cnt++;
				} elseif ( $itemmeta === 'Complete Diamond Setting'  ) {
					$body['diamond_sku'] = get_post_meta( $product->get_id(), 'diamond_sku', true);
					$cnt_final++;
				} else if( $itemmeta === 'Complete Ring Setting' ){
					$body['ring_sku']      = $product->get_sku();
					$cnt_final++;
				}

				// Trigger the API call when cnt reaches 1 or 2
				if ( $cnt === 1 || $cnt_final === 2 ) {
					$response = $this->tdprb_order_API( $body );
					$this->tdprb_log_api_response( $response, $log_file, $order_id );
					$cnt = 0; // Reset counter after each API call
					$body['diamond_type'] = '';
					$body['diamond_sku'] = '';
					$body['ring_sku'] = '';
					if ( $cnt_final == 2 ) {
						$cnt_final = 0;
					}
				}
			}

			// Flag the action as done (to avoid repetitions on reload for example)
			$order->update_meta_data( '_thankyou_action_done', true );
			$order->save();
		}
	}

	/**
	 * Perform the API call to place the order.
	 *
	 * @param array $body The API request body.
	 * @return array|WP_Error The response or WP_Error on failure.
	 */
	private function tdprb_order_API( $body ) {
		return wp_remote_post( TDPRB_ORDER_PLACE_API, array(
			'body'        => $body,
			'timeout'     => 120,
			'redirection' => 10,
			'httpversion' => '1.1',
			'blocking'    => true,
			'headers'     => array(),
			'cookies'     => array(),
			'sslverify'   => false, // Ensure this is used with caution
		));
	}

	/**
	 * Log the API response.
	 *
	 * @param array|WP_Error $response The API response or WP_Error object.
	 * @param string         $log_file The path to the log file.
	 * @param int            $order_id The order ID.
	 * @return void
	 */
	private function tdprb_log_api_response( $response, $log_file, $order_id ) {
		global $wp_filesystem;
	
		// Ensure WP_Filesystem is loaded
		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
	
		WP_Filesystem();
		$log_entry = '';
		// Handle WP_Error
		if ( is_wp_error( $response ) ) {
			$error_message = $response->get_error_message();
			$log_entry .= "API Error:\n" . sanitize_text_field( $error_message ) . "\n";
		} else {
			// Decode response and log it
			$data = json_decode( wp_remote_retrieve_body( $response ), true );
			
			// Use wp_json_encode() instead of print_r()
			$log_entry .= "Order ID: " . intval( $order_id ) . "\n";
			$log_entry .= "API Response Data:\n" . wp_json_encode( $data, JSON_PRETTY_PRINT ) . "\n"; // Safe JSON logging
		}
	
		// Ensure log file path is absolute
		if ( ! $wp_filesystem->exists( $log_file ) ) {
			// Create the file if it doesn't exist
			if ( ! $wp_filesystem->put_contents( $log_file, $log_entry, FS_CHMOD_FILE ) ) {
				error_log( 'Failed to create log file: ' . sanitize_text_field( $log_file ) );
				return;
			}
		} else {
			// If file exists, append content
			$existing_content = $wp_filesystem->get_contents( $log_file );
			$log_entry = $existing_content . "\n" . $log_entry;
		}
	
		// Write to the log file
		if ( ! $wp_filesystem->put_contents( $log_file, $log_entry, FS_CHMOD_FILE ) ) {
			error_log( 'Failed to write to log file: ' . sanitize_text_field( $log_file ) );
		} else {
			error_log( 'Log successfully written to: ' . sanitize_text_field( $log_file ) );
		}
	}
	
}