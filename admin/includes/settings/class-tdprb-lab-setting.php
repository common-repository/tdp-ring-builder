<?php

/**
 * Class TDPRB_Lab_Settings
 *
 * Handles the Lab settings for the TDPRB plugin.
 */
class TDPRB_Lab_Settings {

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
        include( TDPRB_DIR_PATH . "/admin/partials/tdprb-admin-lab-grown-settings.php" );
    }

    /**
     * Registers the settings
     *
     * Registers the settings group and settings with WordPress.
     */
    public function register() {
	
        register_setting(
            'tdprb_lab_settings_group', // Option group
            'tdprb_lab_settings', // Option name
            [
                'type'              => 'array',
                'sanitize_callback' => [$this, 'sanitizeSettings'],
                'default'           => $this->defaultLabSetting(),
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
    public function defaultLabSetting() {
		return [
			'diamond_title' => 'Lab Grown Diamonds',
			'search_filters' => $this->get_searchFilter(),
			'product_with_image' => '',
			'product_with_video' => '',
			'default_view' => 'grid',
			'show_grid_view' => '1',
			'show_list_view' => '1',
			'list_view_customization' => [
				['text' => 'View',    'key' => 'view',    'status' => ''],
				['text' => 'Shape',   'key' => 'shape',   'status' => 'show'],
				['text' => 'Carat',   'key' => 'carat',   'status' => 'show'],
				['text' => 'Color',   'key' => 'color',   'status' => 'show'],
				['text' => 'Clarity', 'key' => 'clarity', 'status' => ''],
				['text' => 'Cut',     'key' => 'cut',     'status' => 'show'],
				['text' => 'Report',  'key' => 'lab', 	  'status' => 'show'],
				['text' => 'Price',   'key' => 'price',   'status' => 'show']
			],
			'diamond_details_customization' => [
				['text' => 'IGI', 		'key' => 'lab', 'status' => ''],
				['text' => 'Shape', 	'key' => 'shape', 'status' => 'show'],
				['text' => 'Carat', 	'key' => 'carat', 'status' => 'show'],
				['text' => 'Color', 	'key' => 'color', 'status' => ''],
				['text' => 'Clarity', 	'key' => 'clarity', 'status' => 'show'],
				['text' => 'Cut', 		'key' => 'cut', 'status' => 'show'],
				['text' => 'Polish', 	'key' => 'polish', 'status' => 'show'],
				['text' => 'Symmetry', 		'key' => 'symmetry', 'status' => ''],
				['text' => 'Fluorescence', 	'key' => 'fluorescence', 'status' => 'show'],
				['text' => 'Price', 'key' => 'price',  'status' => 'show'],
				['text' => 'Table', 'key' => 'table_per', 'status' => 'show'],
				['text' => 'Depth', 'key' => 'depth_per', 'status' => 'show'],
				['text' => 'L/W Ratio', 'key' => 'lwratio', 'status' => 'show'],
				['text' => 'Measurement', 'key' => 'measurement', 'status' => 'show'],
				['text' => 'Crown Angle', 'key' => 'crown_angle', 'status' => 'show'],
				['text' => 'Pavilion Angle', 'key' => 'pavilion_angle', 'status' => 'show'],
				['text' => 'Girdle Thick', 'key' => 'girdle_thick', 'status' => 'show'],
				['text' => 'Girdle %', 'key' => 'gridle_per', 'status' => 'show'],
				['text' => 'Eye Clean', 'key' => 'eyeclean', 'status' => 'show']
			],
			'search_limits' => [
				'carats' => [
					'carats_max' => '30',
					'carats_min' => '0.1',
					'carats_stepper' => '0.1'
				],
				'depth_pr' => [
					'depth_pr_max' => '100',
					'depth_pr_min' => '1'
				],
				'price' => [
					'price_max' => '100000',
					'price_min' => '0',
					'price_stepper' => '1000'
				],
				'table_pr' => [
					'table_pr_max' => '100',
					'table_pr_min' => '1'
				],
				'l_w_ratio' => [
					'l_w_ratio_max' => '100',
					'l_w_ratio_min' => '1'
				]
			],
			'locations' => [
				'india' => 'india',
				'israel' => 'israel',
				'canada' => 'canada',
				'united_states' => 'united_states',
				'belgium' => 'belgium',
				'hong_kong' => 'hong_kong',
				'australia' => 'australia',
				'united_kingdom' => 'united_kingdom',
				'uae' => 'uae'
			],
			'page_size' => 12,
			'items_per_row' => 4
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

		return [
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
				'key' => 'color',
				'text' => 'Color',
				'type' => 'slider',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_color',
						'status' => ''
					],
					[
						'text' => 'L',
						'value' => 'L',
						'status' => 'show'
					],
					[
						'text' => 'K',
						'value' => 'K',
						'status' => 'show'
					],
					[
						'text' => 'J',
						'value' => 'J',
						'status' => 'show'
					],
					[
						'text' => 'I',
						'value' => 'I',
						'status' => 'show'
					],
					[
						'text' => 'H',
						'value' => 'H',
						'status' => 'show'
					],
					[
						'text' => 'G',
						'value' => 'G',
						'status' => 'show'
					],
					[
						'text' => 'F',
						'value' => 'F',
						'status' => 'show'
					],
					[
						'text' => 'E',
						'value' => 'E',
						'status' => 'show'
					],
					[
						'text' => 'D',
						'value' => 'D',
						'status' => 'show'
					]
				],
				'status' => 'show',
				'isSubItem' => true,
				'advancefilter' => false
			],
			[
				'key' => 'carats',
				'text' => 'Carats',
				'type' => 'slider-minmax',
				'items' => [],
				'status' => 'show',
				'isSubItem' => false,
				'advancefilter' => false
			],
			[
				
				'key' => 'clarity',
				'text' => 'Clarity',
				'type' => 'slider',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_clarity',
						'status' => ''
					],
					[
						'text' => 'SI2',
						'value' => 'SI2',
						'status' => 'show'
					],
					[
						'text' => 'SI1',
						'value' => 'SI1',
						'status' => 'show'
					],
					[
						'text' => 'VS2',
						'value' => 'VS2',
						'status' => 'show'
					],
					[
						'text' => 'VS1',
						'value' => 'VS1',
						'status' => 'show'
					],
					[
						'text' => 'VVS2',
						'value' => 'VVS2',
						'status' => 'show'
					],
					[
						'text' => 'VVS1',
						'value' => 'VVS1',
						'status' => 'show'
					],
					[
						'text' => 'IF',
						'value' => 'IF',
						'status' => 'show'
					],
					[
						'text' => 'FL',
						'value' => 'FL',
						'status' => 'show'
					],
					[
						'text' => 'I1',
						'value' => 'I1',
						'status' => ''
					],
					[
						'text' => 'I2',
						'value' => 'I2',
						'status' => ''
					]
				],
				'status' => 'show',
				'isSubItem' => true,
				'advancefilter' => false
			],
			[
				'key' => 'cut',
				'text' => 'Cut',
				'type' => 'slider',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_cut',
						'status' => 'show'
					],
					[
						'text' => 'Excellent',
						'value' => 'EX',
						'status' => ''
					],
					[
						'text' => 'Very Good',
						'value' => 'VG',
						'status' => 'show'
					],
					[
						'text' => 'Good',
						'value' => 'GD',
						'status' => 'show'
					],
					[
						'text' => 'Fair',
						'value' => 'FR',
						'status' => 'show'
					],
					[
						'text' => 'Ideal',
						'value' => 'ID',
						'status' => 'show'
					]
				],
				'status' => 'show',
				'isSubItem' => true,
				'advancefilter' => false
			],
			[
				'key' => 'lab',
				'text' => 'Lab',
				'type' => 'checkbox',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_lab',
						'status' => ''
					],
					[
						'text' => 'GIA',
						'value' => 'GIA',
						'status' => 'show'
					],
					[
						'text' => 'IGI',
						'value' => 'IGI',
						'status' => 'show'
					],
					[
						'text' => 'HRD',
						'value' => 'HRD',
						'status' => 'show'
					],
					[
						'text' => 'GCAL',
						'value' => 'GCAL',
						'status' => 'show'
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
				'advancefilter' => false
			],
			[
				'key' => 'polish',
				'text' => 'Polish',
				'type' => 'slider',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_polish',
						'status' => ''
					],
					[
						'text' => 'Excellent',
						'value' => 'EX',
						'status' => 'show'
					],
					[
						'text' => 'Very Good',
						'value' => 'VG',
						'status' => 'show'
					],
					[
						'text' => 'Good',
						'value' => 'GD',
						'status' => 'show'
					],
					[
						'text' => 'Fair',
						'value' => 'FR',
						'status' => 'show'
					],
					[
						'text' => 'Ideal',
						'value' => 'ID',
						'status' => 'show'
					]
				],
				'status' => 'show',
				'isSubItem' => true,
				'advancefilter' => true
			],
			[
				'key' => 'symmetry',
				'text' => 'Symmetry',
				'type' => 'slider',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_symmetry',
						'status' => ''
					],
					[
						'text' => 'Excellent',
						'value' => 'EX',
						'status' => 'show'
					],
					[
						'text' => 'Very Good',
						'value' => 'VG',
						'status' => 'show'
					],
					[
						'text' => 'Good',
						'value' => 'GD',
						'status' => 'show'
					],
					[
						'text' => 'Fair',
						'value' => 'FR',
						'status' => 'show'
					],
					[
						'text' => 'Ideal',
						'value' => 'ID',
						'status' => 'show'
					]
				],
				'status' => 'show',
				'isSubItem' => true,
				'advancefilter' => true
			],
			[
				'key' => 'table_pr',
				'text' => 'Table %',
				'type' => 'slider-minmax',
				'items' => [],
				'status' => 'show',
				'isSubItem' => false,
				'advancefilter' => true
			],
			[
				'key' => 'depth_pr',
				'text' => 'Depth %',
				'type' => 'slider-minmax',
				'items' => [],
				'status' => 'show',
				'isSubItem' => false,
				'advancefilter' => true
			],
			[
				'key' => 'fluorescence',
				'text' => 'Fluorescence',
				'type' => 'slider',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_fluorescence',
						'status' => ''
					],
					[
						'text' => 'None',
						'value' => 'NON',
						'status' => 'show'
					],
					[
						'text' => 'Faint',
						'value' => 'FNT',
						'status' => 'show'
					],
					[
						'text' => 'Medium',
						'value' => 'MED',
						'status' => 'show'
					],
					[
						'text' => 'Strong',
						'value' => 'STG',
						'status' => 'show'
					]
				],
				'status' => 'show',
				'isSubItem' => true,
				'advancefilter' => true
			],
			[
				'key' => 'l_w_ratio',
				'text' => 'L/W Ratio',
				'type' => 'slider-minmax',
				'items' => [],
				'status' => 'show',
				'isSubItem' => false,
				'advancefilter' => true
			],
			[
				'key' => 'fancy_color',
				'text' => 'Fancy Color',
				'type' => 'select',
				'items' => [
					[
						'text' => 'All',
						'value' => 'all_fancy_color',
						'status' => ''
					],
					[
						'text' => 'Yellow',
						'value' => 'yellow',
						'status' => 'show'
					],
					[
						'text' => 'Pink',
						'value' => 'pink',
						'status' => 'show'
					],
					[
						'text' => 'Purple',
						'value' => 'purple',
						'status' => 'show'
					],
					[
						'text' => 'Red',
						'value' => 'red',
						'status' => 'show'
					],
					[
						'text' => 'Blue',
						'value' => 'blue',
						'status' => 'show'
					],
					[
						'text' => 'Green',
						'value' => 'green',
						'status' => 'show'
					],
					[
						'text' => 'Orange',
						'value' => 'orange',
						'status' => 'show'
					],
					[
						'text' => 'Brown',
						'value' => 'brown',
						'status' => 'show'
					],
					[
						'text' => 'Black',
						'value' => 'black',
						'status' => 'show'
					],
					[
						'text' => 'Gray',
						'value' => 'gray',
						'status' => 'show'
					]
				],
				'status' => 'show',
				'isSubItem' => true,
				'advancefilter' => true
			]
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