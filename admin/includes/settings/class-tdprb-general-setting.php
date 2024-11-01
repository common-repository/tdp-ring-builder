<?php

/**
 * Class TDPRB_General_Settings
 *
 * Handles the general settings for the TDPRB plugin.
 */
class TDPRB_General_Settings {

    /**
     * Constructor
     *
     * Initializes the class and sets up any necessary hooks.
     */
    public function __construct() {
        // Constructor logic here if needed
    }

    /**
     * Renders the settings page
     *
     * Includes the settings page template based on the access token value.
     */
    public function render() {
        include(TDPRB_DIR_PATH . "/admin/partials/tdprb-admin-general-settings.php");
    }

    /**
     * Registers the settings
     *
     * Registers the settings group and settings with WordPress.
     */
    public function register() {
        register_setting(
            'tdprb_settings_group', // Option group
            'tdprb_settings', // Option name
            [
                'type'              => 'array',
                'sanitize_callback' => [$this, 'sanitizeSettings'],
                'default'           => $this->defaultGenralSetting(),
            ]
        );
    }

    /**
     * Provides default settings
     *
     * Returns the default settings for the plugin.
     *
     * @return array Default settings
     */
    public function defaultGenralSetting() {
        return [
            'default_type' => 'both',
            'layout' => 'normal',
            'theme_colors' => [
                'background' => '#ffffff',
                'theme'      => '#172568',
                'border'     => '#DCDCDC',
                'text1'      => '#1E1E1E',
                'text2'      => '#464646',
            ],
            'details_page_links' => [
                'book_appointment_link'    => '',
                'virtual_consultation_link' => '',
            ],
            'product_advertisement_links' => [
                'diamond_details_ad' => [
                    'link'                  => '',
                    'redirect_link'         => '',
                ],
                'setting_details_ad' => [
                    'link'                  => '',
                    'redirect_link'         => '',
                ],
            ],
            'list_advertisement_links' => [
                'diamond_list_ad' => [
                    'link'          => '',
                    'redirect_link' => '',
                    'interval'      => 8,
                ],
                'setting_list_ad' => [
                    'link'          => '',
                    'redirect_link' => '',
                    'interval'      => 8,
                ],
            ],
            'header_texts' => [
                'diamond' => [
                    'primary'   => 'Diamond',
                    'secondary' => 'Choose your diamond',
                ],
                'setting' => [
                    'primary'   => 'Setting',
                    'secondary' => 'Choose your settings',
                ],
                'complete_ring' => [
                    'primary'   => 'Complete Ring',
                    'secondary' => 'Review your settings',
                ],
            ],
            'tabs_texts' => [
                'natural_diamonds'      => 'Natural Diamonds',
                'lab_grown_diamonds'    => 'Lab Grown Diamonds',
            ],
            'diamond_texts' => [
                'add_to_cart'            => 'Add to Cart',
                'select_this_setting'   => 'Select this Setting',
            ],
            'setting_texts' => [
                'add_to_cart'            => 'Add to Cart',
                'select_this_setting'   => 'Select this Setting',
            ],
            'product_detail_texts' => [
                'text1' => 'Text 1',
                'text2' => 'Text 2',
                'text3' => 'Text 3',
            ],
            'complete_rings_texts' => [
                'complete_rings_texts' => 'Engagement Ring',
                'checkout_button_text' => 'Proceed to Shopping Bag',
                'order_summary'        => 'Order Summary',
                'ring_size_text'       => 'Select Ring Size',
            ],
            'inline_css' => [
                'value' => '',
            ],
        ];
    }

    /**
     * Sanitizes the settings input
     *
     * Sanitizes the input values for the settings before saving.
     *
     * @param array $_POST The input values from the settings form.
     * @return array Sanitized input values.
     */

     public function sanitizeSettings($input) {

		include_once TDPRB_DIR_PATH . '/admin/includes/class-tdprb-data-sanitizer.php';
		$TDPRB_DynamicDataSanitizer = new TDPRB_DynamicDataSanitizer();
		$sanitized_input = $TDPRB_DynamicDataSanitizer->sanitize($input);
    
        return $sanitized_input;
    }
    
}