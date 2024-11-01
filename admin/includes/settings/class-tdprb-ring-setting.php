<?php

/**
 * Class TDPRB_Ring_Settings
 *
 * Handles the Ring settings for the TDPRB plugin.
 */
class TDPRB_Ring_Settings {

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
        include(TDPRB_DIR_PATH . "/admin/partials/tdprb-admin-ring-settings.php");
    }

    /**
     * Registers the settings
     *
     * Registers the settings group and settings with WordPress.
     */
    public function register() {
        register_setting(
            'tdprb_ring_settings_group', // Option group
            'tdprb_ring_settings', // Option name
            [
                'type'              => 'array',
                'sanitize_callback' => [$this, 'sanitizeSettings'],
                'default'           => $this->defaultRingSetting(),
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
    public function defaultRingSetting() {
        return [
            'search_filters' => $this->get_searchFilter(),
            'product_with_image' => '',
            'details_customization' => [
                [
                    'text' => 'Type',
                    'key'  => 'type',
                    'status' => '',
                ],
                [
                    'text' => 'Metal',
                    'key'  => 'metal',
                    'status' => 'show',
                ],
                [
                    'text' => 'Brand',
                    'key'  => 'brand',
                    'status' => 'show',
                ],
                [
                    'text' => 'Item Location',
                    'key'  => 'itemlocation',
                    'status' => 'show',
                ],
            ],
            'search_limits' => [
				'price' => [
					'price_max' => '100000',
					'price_min' => '0',
					'price_stepper' => '1000'
				]
			],
			'locations' => [
				'india' => '',
				'israel' => '',
				'canada' => '',
				'united_states' => '',
				'belgium' => '',
				'hong_kong' => '',
				'australia' => '',
				'united_kingdom' => '',
				'uae' => ''
			],
			'page_size' => 12,
			'items_per_row' => 4,
            'ring_size' => 'US'
        ];
    }

    /**
     * Retrieves the search filter configuration
     *
     * Returns an array of search filters for the ring settings.
     *
     * @return array Search filters configuration
     */
    
    public function get_searchFilter(){

		return $array = [
            [
                'key' => 'ring_style',
                'text' => 'Ring Style',
                'type' => 'select',
                'items' => [
                    [ 'text' => 'All', 			'key' => 'allstyle', 	'value' => 'all_style', 'status' => '' ],
                    [ 'text' => 'Solitaire', 	'key' => 'solitaire',	'value' => 'solitaire', 'status' => 'show'],
                    [ 'text' => 'Halo', 		'key' => 'halo',		'value' => 'halo', 'status' => ''],
                    [ 'text' => 'Three Stone', 	'key' => 'threestone',	'value' => 'three-stone', 'status' => 'show'],
                    [ 'text' => 'Hidden Halo', 	'key' => 'hiddenhalo',	'value' => 'hidden halo', 'status' => 'show'],
                    [ 'text' => 'Pavé', 		'key' => 'pave',		'value' => 'pave', 'status' => 'show'],
                    [ 'text' => 'Unique', 		'key' => 'unique',		'value' => 'unique', 'status' => 'show'],
                    [ 'text' => 'Vintage', 		'key' => 'vintage',		'value' => 'vintage', 'status' => 'show'],
                    [ 'text' => 'Round', 		'key' => 'round',		'value' => 'round', 'status' => 'show'],
                    [ 'text' => 'Side Stone', 	'key' => 'sidestone',	'value' => 'side_stone', 'status' => ''],
                    [ 'text' => 'Twist', 		'key' => 'twist',		'value' => 'twist', 'status' => ''],
                    [ 'text' => 'Multi Row', 	'key' => 'multirow',	'value' => 'multi_row', 'status' => ''],
                ],
                'status' => 'show',
                'isSubItem' => true,
            ],
            [
				'key' => 'shape',
				'text' => 'Shape',
				'type' => 'select',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_shape',
						'key' => 'allshape',
						'status' => ''
					],
					[
						'text' => 'Round',
						'value' => 'round',
						'key' 	=> 'round',
						'status' => 'show'
					],
					[
						'text' => 'Oval',
						'value' => 'oval',
						'key' 	=> 'oval',
						'status' => 'show'
					],
					[
						'text' => 'Cushion',
						'value' => 'cushion',
						'key' 	=> 'cushion',
						'status' => 'show'
					],
					[
						'text' => 'Emerald',
						'value' => 'emerald',
						'key' 	=> 'emerald',
						'status' => 'show'
					],
					[
						'text' => 'Princess',
						'value' => 'princess',
						'key' 	=> 'princess',
						'status' => 'show'
					],
					[
						'text' => 'Radiant',
						'value' => 'radiant',
						'key' 	=> 'radiant',
						'status' => 'show'
					],
					[
						'text' => 'Pear',
						'value' => 'pear',
						'key' 	=> 'pear',
						'status' => 'show'
					],
					[
						'text' => 'Marquise',
						'value' => 'marquise',
						'key' 	=> 'marquise',
						'status' => 'show'
					],
					[
						'text' => 'Asscher',
						'value' => 'asscher',
						'key' 	=> 'asscher',
						'status' => 'show'
					],
					[
						'text' => 'Heart',
						'value' => 'heart',
						'key' 	=> 'heart',
						'status' => 'show'
					],
					[
						'text' => 'SQ.Radiant',
						'value' => 'square radiant',
						'key' 	=> 'squareradiant',
						'status' => ''
					],
					[
						'text' => 'Cushion Mod.',
						'value' => 'cushion modified',
						'key' 	=> 'cushionmodified',
						'status' => ''
					],
					[
						'text' => 'Square',
						'value' => 'square',
						'key' 	=> 'square',
						'status' => ''
					],
					// [
					// 	'text' => 'Cushion Bri.',
					// 	'value' => 'Cushion Bri.',
					// 	'status' => ''
					// ],
					[
						'text' => 'Trilliant',
						'value' => 'trrilliant',
						'key' 	=> 'trrilliant',
						'status' => ''
					],
					// [
					// 	'text' => 'Old Minar',
					// 	'value' => 'oldminar',
					// 	'status' => ''
					// ],
					[
						'text' => 'Star',
						'value' => 'star',
						'key' 	=> 'star',
						'status' => ''
					],
					[
						'text' => 'Rose',
						'value' => 'rose',
						'key' 	=> 'rose',
						'status' => ''
					],
					[
						'text' => 'Half Moon',
						'value' => 'halfmoon',
						'key' 	=> 'halfmoon',
						'status' => ''
					],
					[
						'text' => 'Trapezoid',
						'value' => 'trapezoid',
						'key' 	=> 'trapezoid',
						'status' => ''
					],
					[
						'text' => 'Flanders',
						'value' => 'flanders',
						'key' 	=> 'flanders',
						'status' => ''
					],
					[
						'text' => 'Briolette',
						'value' => 'briolette',
						'key' 	=> 'briolette',
						'status' => ''
					],
					[
						'text' => 'Pentagonal',
						'value' => 'pentagonal',
						'key' 	=> 'pentagonal',
						'status' => ''
					],
					[
						'text' => 'Hexagonal',
						'value' => 'hexagonal',
						'key' 	=> 'hexagonal',
						'status' => ''
					],
					[
						'text' => 'Octagonal',
						'value' => 'octagonal',
						'key' 	=> 'octagonal',
						'status' => ''
					],
					[
						'text' => 'Triangular',
						'value' => 'triangular',
						'key' 	=> 'triangular',
						'status' => ''
					],
					[
						'text' => 'Calf',
						'value' => 'calf',
						'key' 	=> 'calf',
						'status' => ''
					],
					[
						'text' => 'Shield',
						'value' => 'shield',
						'key' 	=> 'shield',
						'status' => ''
					],
					[
						'text' => 'Lozenge',
						'value' => 'lozenge',
						'key' 	=> 'lozenge',
						'status' => ''
					],
					[
						'text' => 'Kite',
						'value' => 'kite',
						'key' 	=> 'kite',
						'status' => ''
					],
					// [
					// 	'text' => 'European Ct.',
					// 	'value' => 'European Ct.',
					// 	'status' => ''
					// ],
					[
						'text' => 'Baguette',
						'value' => 'baguette',
						'key' 	=> 'baguette',
						'status' => ''
					],
					[
						'text' => 'Tapered Bag.',
						'value' => 'baguette',
						'key' 	=> 'taperedbag',
						'status' => ''
					],
					[
						'text' => 'Tapered Bul.',
						'value' => 'baguette',
						'key' 	=> 'taperedbul',
						'status' => ''
					],
					[
						'text' => 'Bullet',
						'value' => 'bullet',
						'key' 	=> 'bullet',
						'status' => ''
					],
					[
						'text' => 'Other',
						'value' => 'other',
						'key' 	=> 'other',
						'status' => ''
					]
				],
				'status' => 'show',
				'isSubItem' => true,
				'advancefilter' => false
			],
            [
                'key' => 'price',
                'text' => 'Price',
                'type' => 'slider-minmax',
                'items' => [],
                'status' => 'show',
                'isSubItem' => false,
                'advancefilter' => false,
            ],
            [
                'key' => 'metal',
                'text' => 'Metal',
                'type' => 'select',
                'items' => [
                    ['text' => 'All', 				'key' 	=> 'allmetal', 'value' => 'all_metal', 'status' => ''],
                    ['text' => '10KT White Gold', 	'key' 	=> '10ktwhitegold', 'value' => '10KT White Gold', 'status' => ''],
                    ['text' => '14KT White Gold', 	'key' 	=> '14ktwhitegold', 'value' => '14KT White Gold', 'status' => 'show'],
                    ['text' => '18KT White Gold', 	'key' 	=> '18ktwhitegold', 'value' => '18KT White Gold', 'status' => 'show'],
                    ['text' => '20KT White Gold', 	'key' 	=> '20ktwhitegold', 'value' => '20KT White Gold', 'status' => ''],
                    ['text' => '22KT White Gold', 	'key' 	=> '22ktwhitegold', 'value' => '22KT White Gold', 'status' => ''],
                    ['text' => '10KT Yellow Gold', 	'key' 	=> '10ktyellowgold', 'value' => '10KT Yellow Gold', 'status' => ''],
                    ['text' => '14KT Yellow Gold', 	'key' 	=> '14ktyellowgold', 'value' => '14KT Yellow Gold', 'status' => 'show'],
                    ['text' => '18KT Yellow Gold', 	'key' 	=> '18ktyellowgold', 'value' => '18KT Yellow Gold', 'status' => 'show'],
                    ['text' => '20KT Yellow Gold', 	'key' 	=> '20ktyellowgold', 'value' => '20KT Yellow Gold', 'status' => ''],
                    ['text' => '22KT Yellow Gold', 	'key' 	=> '22ktyellowgold', 'value' => '22KT Yellow Gold', 'status' => ''],
                    ['text' => '10KT Rose Gold', 	'key' 	=> '10ktrosegold', 'value' => '10KT Rose Gold', 'status' => ''],
                    ['text' => '14KT Rose Gold', 	'key' 	=> '14ktrosegold', 'value' => '14KT Rose Gold', 'status' => 'show'],
                    ['text' => '18KT Rose Gold', 	'key' 	=> '18ktrosegold', 'value' => '18KT Rose Gold', 'status' => 'show'],
                    ['text' => '20KT Rose Gold', 	'key' 	=> '20ktrosegold', 'value' => '20KT Rose Gold', 'status' => ''],
                    ['text' => '22KT Rose Gold', 	'key' 	=> '22ktrosegold', 'value' => '22KT Rose Gold', 'status' => ''],
                    ['text' => 'Platinum', 			'key' 	=> 'platinum', 'value' => 'Platinum', 'status' => 'show'],
                ],
                'status' => 'show',
                'isSubItem' => true,
            ]
        ];
		 return $searchFilter;
	}

    /**
     * Sanitizes the settings input
     *
     * Sanitizes the input values for the settings before saving.
     *
     * @param array $input The input values from the settings form.
     * @return array Sanitized input values.
     */
    public function sanitizeSettings($input) {

        include_once TDPRB_DIR_PATH . '/admin/includes/class-tdprb-data-sanitizer.php';
		$TDPRB_DynamicDataSanitizer = new TDPRB_DynamicDataSanitizer();
		$sanitized_input = $TDPRB_DynamicDataSanitizer->sanitize($input);
      
        return $sanitized_input;
    }
}