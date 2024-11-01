<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://thediamondport.com/
 * @since      1.0.0
 *
 * @package    TDP_Ring_Builder
 * @subpackage TDP_Ring_Builder/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Check user capabilities
if ( ! current_user_can( 'manage_options' ) ) {
    return;
}

// show error/update messages
settings_errors();

$TDPRB_Admin = new TDPRB_Admin();

include_once TDPRB_DIR_PATH . '/admin/includes/class-tdprb-data-sanitizer.php';
$TDPRB_DynamicDataSanitizer = new TDPRB_DynamicDataSanitizer();
$options = $TDPRB_DynamicDataSanitizer->sanitize(get_option('tdprb_lab_settings'));
?>
<div class="tdprb-settings-wrap tdprb-w-90 tdprb-m-auto tdprb-max-w-1400px">
    <h1 class="tdprb-py-4"><?php esc_html_e( 'Lab-Grown Settings', 'tdp-ring-builder' ); ?></h1>
    <form class="tdprb-w-100 tdprb-bg-white tdprb-p-5 tdprb-rounded-lg tdprb-grid-view-shadow" method="post" action="options.php">
        <?php
        settings_fields( 'tdprb_lab_settings_group' );
        do_settings_sections( 'tdprb_lab_settings_group' );
        // Add the nonce field
        wp_nonce_field( 'tdprb_lab_settings_nonce_action', 'tdprb_lab_settings_nonce' );
        ?>
            <div class="tdprb-d-flex tdprb-flex-column tdprb-w-100">
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label   class="tdprb-fs-18 tdprb-fw-700">Diamond Customizable Texts</label>
                        <p class="tdprb-pt-1">This section will allow you to replace customizable text elements on the app</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex  tdprb-flex-column tdprb-gap-3" >
                        <label for="tdprb_lab_diamond_title" class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " >Diamond Title</label>
                        <input class="tdprb-w-100" type="text" name="tdprb_lab_settings[diamond_title]" id="diamond_title" value="<?php echo esc_attr( $options['diamond_title'] ); ?>">
                    </div>
                </div>    
                              
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40 tdprb-p-4">
                        <label for="Both-diamond" class="tdprb-fs-18 tdprb-fw-700">Diamond Search Customization</label>
                        <p class="tdprb-pt-1">This section will allow you to hide and reorder any of the search parameters displayed on the app. (Any items hidden will be excluded from your search results)</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-flex-column tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-justify-start tdprb-align-center tdprb-gap-5">
                        <?php foreach ($options['search_filters'] as $key => $value) : ?>
                            <div class="tdprb-main-item-wrap tdprb-w-100">
                                <label class="tdprb-w-100 tdprb-h-50px tdprb-d-flex tdprb-justify-between tdprb-align-center tdprb-fs-14 tdprb-fw-500 tdprb-border tdprb-border-gray-medium tdprb-rounded-lg tdprb-px-3 tdprb-cursor-pointer" for="list-view-custome-select-all">
                                    <div class="tdprb-cursor-pointer">
                                        <?php echo esc_html($value['text']); ?>
                                    </div>
                                    <div class="tdprb-sub-options tdprb-d-flex tdprb-justify-center tdprb-gap-10px tdprb-align-center">
                                        <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][isSubItem]" value="<?php echo esc_attr($value['isSubItem']); ?>">
                                        <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][key]" value="<?php echo esc_attr($value['key']); ?>">
                                        <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][text]" value="<?php echo esc_attr($value['text']); ?>">
                                        <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][type]" value="<?php echo esc_attr($value['type']); ?>">
                                        
                                        <?php foreach ($value as $sub_key => $sub_value) : ?>
                                            <?php if ( trim($sub_key) == 'isSubItem' && trim($value['isSubItem']) ) : ?>
                                                <div class="tdprb-sub-items sub-items">
                                                    <label class="tdprb-sub-items-label sub-items tdprb-border tdprb-border-gray-light tdprb-p-2 tdprb-rounded-lg tdprb-button-shadow tdprb-cursor-pointer">
                                                        Sub items
                                                    </label>
                                                </div>
                                            <?php elseif ( trim($sub_key) == 'advancefilter' ) : ?>
                                                <div class="tdprb-sub-item include-advanced-filter">
                                                    <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][advancefilter]" value="">
                                                    <input type="checkbox" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][advancefilter]" id="search_filters_advancefilter_<?php echo esc_attr($value['key']); ?>" value="1" <?php checked(1, $value['advancefilter']); ?> />
                                                    <label for="search_filters_advancefilter_<?php echo esc_attr($value['key']); ?>">
                                                        Include in Advanced Filter
                                                    </label>
                                                </div>
                                            <?php elseif ( trim($sub_key) == 'status' ) : ?>
                                                <div class="tdprb-sub-items show tdprb_<?php echo esc_attr($value['key']); ?>_display">
                                                    <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][status]" value="<?php echo ( $value['text'] == 'Shape' ) ? 'show' : ''; ?>">
                                                    <input type="checkbox" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][status]" id="search_filters_status_<?php echo esc_attr($value['key']); ?>" value="show" <?php checked('show', $value['status']); ?> />
                                                    <label for="search_filters_status_<?php echo esc_attr($value['key']); ?>">
                                                        Show
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </label>
                                <?php if( !empty($value['items']) ) : ?>
                                    <div class="tdprb-sub-items tdprb-options-slide-wrap">
                                        <div class="tdprb-options-wrap">
                                            <?php foreach ($value['items'] as $sub_key => $sub_value) : ?>
                                                <div class="tdprb-sub-items-item tdprb-justify-start">
                                                    <?php if( $value['key'] == 'shape' ): ?>
                                                        <label class="tdprb-h-100 tdprb-h-100px tdprb-w-85px tdprb-d-flex tdprb-justify-center tdprb-align-center tdprb-flex-column tdprb-gap-10px tdprb-cursor-pointer tdprb-border-1 tdprb-border-transparent <?php echo esc_attr($sub_value['text'] == 'All' ? 'tdprb-shape-all-check' : 'tdprb-shape-click'); ?> <?php echo esc_attr($sub_value['status'] == 'show' ? 'tdprb-box-shadow' : ''); ?>" for="tdprb-shapes-<?php echo esc_attr($sub_value['text']); ?>">
                                                            <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][text]" value="<?php echo esc_attr($sub_value['text']); ?>">
                                                            <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][value]" value="<?php echo esc_attr($sub_value['value']); ?>">
                                                            <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][key]" value="<?php echo esc_attr($sub_value['key']); ?>">
                                                            <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][status]" value="">
                                                            <input type="checkbox" class="tdprb-visiblity-hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][status]" id="tdprb-shapes-<?php echo esc_attr($sub_value['text']); ?>" value="show" <?php checked('show', $sub_value['status']); ?> />
                                                            <div class="tdprb-w-50px tdprb-aspect-ratio-1 tdprb-bg-no-repeat tdprb-bg-position-center <?php echo esc_attr($sub_value['text'] == 'All' ? 'tdprb-all' : ''); ?>" id="tdprb-shape-<?php echo esc_attr($TDPRB_Admin->convertToId($sub_value['value'])); ?>">
                                                            </div>
                                                            <div class="tdprb-ff-poppins tdprb-fw-400 tdprb-fs-14 tdprb-lh-1 tdprb-text-dark-blue tdprb-d-flex tdprb-text-center tdprb-justify-center tdprb-transition-transform tdprb-text-capitalize">
                                                                <?php echo esc_html($sub_value['text']); ?>
                                                            </div>
                                                        </label>
                                                    <?php endif; ?>
                                                    <?php if( $value['key'] != 'shape' ): ?>
                                                        <?php
                                                            $ele_id = '';
                                                            $subvalue = isset($sub_value['value']) ? esc_attr($sub_value['value']) : '';
                                                            if( $value['key'] == 'polish' ){
                                                                $ele_id = 'tdprb-' . esc_attr($value['key']) . '-' . esc_attr($subvalue);
                                                            } elseif( $value['key'] == 'symmetry' ){
                                                                $ele_id = 'tdprb-' . esc_attr($value['key']) . '-' . esc_attr($subvalue);
                                                            } else {
                                                                $ele_id = 'tdprb-' . esc_attr($subvalue);
                                                            }
                                                        ?>
                                                        <label class="tdprb-h-100 tdprb-d-flex tdprb-p-5px tdprb-justify-center tdprb-align-center tdprb-flex-column tdprb-gap-10px tdprb-cursor-pointer tdprb-border-1 tdprb-border-transparent tdprb-box-shadow <?php echo esc_attr( $sub_value['text'] == 'All'  ? 'tdprb-not-shape-all-check' : 'tdprb-notshape-click' ) ;?>  <?php echo esc_attr($sub_value['status'] == 'show' ? 'tdprb-option-active' : ''); ?>" for="<?php echo esc_attr($ele_id); ?>">
                                                            <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][text]" value="<?php echo esc_attr($sub_value['text']); ?>">
                                                            <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][value]" value="<?php echo esc_attr($sub_value['value']); ?>">
                                                            <input type="hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][status]" value="">
                                                            <input type="checkbox" class="tdprb-visiblity-hidden" name="tdprb_lab_settings[search_filters][<?php echo esc_attr($value['key']); ?>][items][<?php echo esc_attr($sub_key); ?>][status]" id="<?php echo esc_attr($sub_key); ?>" value="show" <?php checked('show', $sub_value['status']); ?> />
                                                            <div class="tdprb-ff-poppins tdprb-fw-400 tdprb-fs-14 tdprb-lh-1 tdprb-d-flex tdprb-justify-center tdprb-align-center tdprb-flex-column tdprb-gap-10px tdprb-cursor-pointer tdprb-border-1 tdprb-border-transparent tdprb-not-shape tdprb-rounded-md tdprb-transition-transform">
                                                                <?php echo esc_html($sub_value['text']); ?>
                                                            </div>
                                                        </label>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label   class="tdprb-fs-18 tdprb-fw-700">Show Products with Images</label>
                        <p class="tdprb-pt-1">Uncheck the checkbox to allow items without images in your diamond search results</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-h-60px  tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-justify-start tdprb-align-center tdprb-gap-5">
                        <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                            <input type="hidden" name="tdprb_lab_settings[product_with_image]" value="">
                            <input name="tdprb_lab_settings[product_with_image]" type="checkbox" value="1" id="product_with_image" <?php echo ( (int) $options['product_with_image'] === (int) '1' ) ? 'checked' : '';?> >
                            <label for="product_with_image">Show product with image only</label>
                        </div>
                    </div>
                </div>

                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label   class="tdprb-fs-18 tdprb-fw-700">Show Products with Videos</label>
                        <p class="tdprb-pt-1">Uncheck the checkbox to allow items without videos in your diamond search results</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-h-60px  tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-justify-start tdprb-align-center tdprb-gap-5">
                        <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                          
                                <input type="hidden" name="tdprb_lab_settings[product_with_video]" value="">
                                <input name="tdprb_lab_settings[product_with_video]" type="checkbox" value="1" id="product_with_video" <?php echo ( (int) $options['product_with_video'] === (int) '1' ) ? 'checked' : '';?> >
                                <label for="product_with_video">Show product with video only</label>
                           
                        </div>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700">Grid and List View Visibility Settings</label>
                        <p class="tdprb-pt-1">Uncheck the checkbox if you want to suppress any specific view (Grid or List) from the results page.</p>
                    </div>
                    <div class="tdprb-view-main-wrap tdprb-w-60 tdprb-d-flex tdprb-flex-column tdprb-justify-start tdprb-align-start tdprb-gap-2">
                        <div class="tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-flex-column tdprb-justify-start tdprb-align-start tdprb-gap-2">
                            <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                                <input type="hidden" name="tdprb_lab_settings[show_grid_view]" value="">
                                <input name="tdprb_lab_settings[show_grid_view]" type="checkbox" value="1" class="tdprb-show-view" id="show_grid_view" <?php echo ( (int) $options['show_grid_view'] === (int) '1' ) ? 'checked' : '';?> >
                                <label for="show_grid_view">Show Grid View</label>
                                
                                <input type="hidden" name="tdprb_lab_settings[show_list_view]" value="">
                                <input name="tdprb_lab_settings[show_list_view]" type="checkbox" value="1" class="tdprb-show-view" id="show_list_view" <?php echo ( (int) $options['show_list_view'] === (int) '1' ) ? 'checked' : '';?> >
                                <label for="show_list_view">Show List View</label>
                            </div>
                        </div>     
                       
                        <div class="tdprb-grid-list-view tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-justify-start tdprb-align-start tdprb-gap-3 <?php echo ( ( !empty( $options['show_grid_view'] ) && !empty($options['show_list_view'] ) ) ) ? '' : 'tdprb-d-none' ; ?>">
                            <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                                <input name="tdprb_lab_settings[default_view]" type="radio" value="grid" id="Default-show-grid-view" <?php echo ( $options['default_view'] === 'grid' ) ? 'checked' : '';?>>
                                <label for="Default-show-grid-view">Set Grid View Default</label>
                            </div>
                            <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                                <input name="tdprb_lab_settings[default_view]" type="radio" value="list" id="Default-show-list-view" <?php echo ( $options['default_view'] === 'list' ) ? 'checked' : '';?>>
                                <label for="Default-show-list-view">Set List View Default</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4 tdprb-list-view-customization">
                    <div class="tdprb-w-40 tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700" for="book-appointment-links">List View Customization</label>
                        <p class="tdprb-pt-1">This section will allow you to hide any of the columns on the list view</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                        <?php foreach( $options['list_view_customization'] as $key => $value ) : ?>
                            <label class="tdprb-show-view-customization tdprb-w-100 tdprb-h-50px tdprb-d-flex tdprb-justify-between tdprb-align-center tdprb-fs-14 tdprb-fw-500 tdprb-border tdprb-border-gray-medium tdprb-rounded-lg tdprb-px-3 tdprb-cursor-pointer" for="list_view_customization_<?php echo esc_attr( $value['text'] ); ?>">
                                <div class="tdprb-cursor-pointer"><?php echo esc_html( $value['text'] ); ?></div>
                                <input type="hidden" name="tdprb_lab_settings[list_view_customization][<?php echo esc_attr( $key ); ?>][text]" value="<?php echo esc_attr( $value['text'] ); ?>">
                                <input type="hidden" name="tdprb_lab_settings[list_view_customization][<?php echo esc_attr( $key ); ?>][key]" value="<?php echo esc_attr( $value['text'] === 'report' ? 'lab' : $value['key'] ); ?>">
                                <input type="hidden" name="tdprb_lab_settings[list_view_customization][<?php echo esc_attr( $key ); ?>][status]" value="">
                                <input class="tdprb-cursor-pointer tdprb-lv-options tdprb-view-customization" name="tdprb_lab_settings[list_view_customization][<?php echo esc_attr( $key ); ?>][status]" type="checkbox" value="show" id="list_view_customization_<?php echo esc_attr( $value['text'] ); ?>" <?php checked( $value['status'], 'show' ); ?>>
                                <label for="list_view_customization_<?php echo esc_attr( $value['text'] ); ?>">Show</label>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4 tdprb-diamond-details-customization">
                    <div class="tdprb-w-40 tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700" for="book-appointment-links">Diamond Details Page Customization</label>
                        <p class="tdprb-pt-1">This section will allow you to hide any of the fields on the diamond detail page</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                        <?php foreach( $options['diamond_details_customization'] as $key => $value ) : ?>
                            <label class="tdprb-show-view-customization tdprb-w-100 tdprb-h-50px tdprb-d-flex tdprb-justify-between tdprb-align-center tdprb-fs-14 tdprb-fw-500 tdprb-border tdprb-border-gray-medium tdprb-rounded-lg tdprb-px-3 tdprb-cursor-pointer" for="diamond_details_customization_<?php echo esc_attr( $value['text'] ); ?>">
                                <div class="tdprb-cursor-pointer"><?php echo esc_html( $value['text'] ); ?></div>
                                <input type="hidden" name="tdprb_lab_settings[diamond_details_customization][<?php echo esc_attr( $key ); ?>][text]" value="<?php echo esc_attr( $value['text'] ); ?>">
                                <input type="hidden" name="tdprb_lab_settings[diamond_details_customization][<?php echo esc_attr( $key ); ?>][key]" value="<?php echo esc_attr( $value['text'] === 'IGI' ? 'lab' : $value['key'] ); ?>">
                                <input type="hidden" name="tdprb_lab_settings[diamond_details_customization][<?php echo esc_attr( $key ); ?>][status]" value="">
                                <input class="tdprb-cursor-pointer tdprb-lv-options tdprb-view-customization" name="tdprb_lab_settings[diamond_details_customization][<?php echo esc_attr( $key ); ?>][status]" type="checkbox" value="show" id="diamond_details_customization_<?php echo esc_attr( $value['text'] ); ?>" <?php checked( $value['status'], 'show' ); ?>>
                                <label for="diamond_details_customization_<?php echo esc_attr( $value['text'] ); ?>">Show</label>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700" for="translations">Search Limits</label>
                        <p class="tdprb-pt-1">This section will allow you to limit the search results to items that fall between the defined ranges. (If this is not defined it will return all items that match your search customizations)</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                        <div class="tdprb-w-100 tdprb-min-h-50px   tdprb-bg-gray tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-3  tdprb-gap-3">
                              
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="carat_min">Carat Min</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][carats][carats_min]" id="carats_min" value="<?php echo esc_attr( $options['search_limits']['carats']['carats_min'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="carat_max">Carat Max</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][carats][carats_max]" id="carats_max" value="<?php echo esc_attr( $options['search_limits']['carats']['carats_max'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="carat_stepper">Carat Stepper</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][carats][carats_stepper]" id="carats_stepper" value="<?php echo esc_attr( $options['search_limits']['carats']['carats_stepper'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="price_min">Price Min</label>     
                                    <input class="tdprb-w-100" type="number" min="0" name="tdprb_lab_settings[search_limits][price][price_min]" id="price_min" pattern="[0-9]{1,6}" title="Price Min must be a number up to 6 digits." value="<?php echo esc_attr( $options['search_limits']['price']['price_min'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="carat_max">Price Max</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][price][price_max]" id="price_max" pattern="[0-9]{1,6}" title="Price Max must be a number up to 6 digits." value="<?php echo esc_attr( $options['search_limits']['price']['price_max'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="carat_stepper">Price Stepper</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][price][price_stepper]" id="price_stepper" pattern="[0-9]{1,6}" title="Price Stepper must be a number up to 6 digits." value="<?php echo esc_attr( $options['search_limits']['price']['price_stepper'] ); ?>">
                                    <span class="tdprb-error-message"></span>
                                </article>
                                    
                            </section>
                        </div>
                        <div class="tdprb-w-100 tdprb-min-h-50px   tdprb-bg-gray tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="depth_min">Depth Min</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][depth_pr][depth_pr_min]" id="depth_pr_min" value="<?php echo esc_attr( $options['search_limits']['depth_pr']['depth_pr_min'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="depth_max">Depth Max</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][depth_pr][depth_pr_max]" id="depth_pr_max" value="<?php echo esc_attr( $options['search_limits']['depth_pr']['depth_pr_max'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="table_min">Table Min</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][table_pr][table_pr_min]" id="table_pr_min" value="<?php echo esc_attr( $options['search_limits']['table_pr']['table_pr_min'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="table_max">Table Max</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][table_pr][table_pr_max]" id="table_pr_max" value="<?php echo esc_attr( $options['search_limits']['table_pr']['table_pr_max'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="lwratio_min">L/W Ratio Min</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][l_w_ratio][l_w_ratio_min]" id="lwratio_min" value="<?php echo esc_attr( $options['search_limits']['l_w_ratio']['l_w_ratio_min'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="lwratio_max">L/W Ratio Min</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_lab_settings[search_limits][l_w_ratio][l_w_ratio_max]" id="lwratio_max" value="<?php echo esc_attr( $options['search_limits']['l_w_ratio']['l_w_ratio_max'] ); ?>">
                                </article>
                            </section>
                        </div>                       
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40 tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700">Exclude Locations</label>
                        <p class="tdprb-pt-1">This section will allow you to restrict items by location</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                        <h3 class="tdprb-fs-20 tdprb-fw-500 tdprb-py-2">Locations</h3>
                        <div class="tdprb-w-50 tdprb-min-h-50px tdprb-bg-gray tdprb-d-grid tdprb-grid-rows-4 tdprb-gap-2 tdprb-grid-auto-flow">
                            <?php if( isset( $options['locations'] ) ): ?>
                                <?php foreach( $options['locations'] as $key => $value ): ?>
                                    <div class="tdprb-d-flex tdprb-justify-start tdprb-w-200px tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                                        <input type="hidden" name="tdprb_lab_settings[locations][<?php echo esc_attr( $key ); ?>]" value="">
                                        <input type="checkbox" name="tdprb_lab_settings[locations][<?php echo esc_attr( $key ); ?>]" value="1" id="tdprb_lab_settings[locations][<?php echo esc_attr( $key ); ?>]" <?php checked( (int) $value, 1 ); ?>>
                                        <label for="tdprb_lab_settings[locations][<?php echo esc_attr( $key ); ?>]"><?php echo esc_html( $TDPRB_Admin->capitalizeFirstWordEachWord( str_replace( '_', ' ', $key ) ) ); ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label   class="tdprb-fs-18 tdprb-fw-700">Results Page Size</label>
                        <p class="tdprb-pt-1">This section will allow you to control how many items will be loaded after the search and as a user scrolls to the results (The default and recomended page size is 12 items)</p>
                    </div>
                 
                    <div class="tdprb-w-60 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex  tdprb-flex-column tdprb-gap-3" >
                        <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="page_size">Results page size</label>     
                        <input class="tdprb-w-100" type="number" min="1" max="50" name="tdprb_lab_settings[page_size]" id="page_size" value="<?php echo isset($options['page_size']) ? esc_attr( $options['page_size'] ) : '';  ?>">
                    </div>
                </div>    
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label   class="tdprb-fs-18 tdprb-fw-700">Search Result Layout</label>
                        <p class="tdprb-pt-1">This section will allow you to control how many result will	appear in a single row (The dafault is 4 items per row).</p>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex  tdprb-flex-column tdprb-gap-3" >
                        <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="items_per_row">Items Per Row</label>     
                        <input class="tdprb-w-100" type="number" min="1" max="6" name="tdprb_lab_settings[items_per_row]" id="items_per_row" value="<?php echo isset($options['items_per_row']) ? esc_attr( $options['items_per_row'] ) : ''; ?>">
                    </div>
                </div>
            </div>
        <div class="tdp-rb-submit-button tdprb-d-flex tdprb-justify-end tdprb-w-100">
            <?php submit_button( __( 'Save Settings', 'tdp-ring-builder' ) ); ?>
        </div>
    </form>
</div>