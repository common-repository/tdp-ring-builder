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

include_once TDPRB_DIR_PATH . '/admin/includes/class-tdprb-data-sanitizer.php';

$TDPRB_DynamicDataSanitizer = new TDPRB_DynamicDataSanitizer();
$options = $TDPRB_DynamicDataSanitizer->sanitize(get_option('tdprb_settings'));
?>
<div class="tdprb-settings-wrap tdprb-w-90 tdprb-m-auto tdprb-max-w-1400px">
    <h1 class="tdprb-py-4"><?php esc_html_e( 'Ring Builder Settings', 'tdp-ring-builder' ); ?></h1>
    <form class="tdprb-w-100 tdprb-bg-white tdprb-p-5 tdprb-rounded-lg tdprb-grid-view-shadow" method="post" action="options.php">
        <?php
        settings_fields( 'tdprb_settings_group' );
        do_settings_sections( 'tdprb_settings_group' );
        wp_nonce_field( 'tdprb_settings_nonce_action', 'tdprb_settings_nonce' );
        ?>

        <div class="tdprb-d-flex tdprb-flex-column tdprb-w-100">
            <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                <div class="tdprb-w-40 tdprb-p-4">
                    <label  for="tdprb_api_key" class="tdprb-fs-18 tdprb-fw-700">API Key</label>
                </div>
                <div class="tdprb-w-60 tdprb-h-100px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex">
                    <div class="tdprb-d-flex tdprb-w-100 tdprb-gap-2">
                        <label  class="tdprb-fs-16 tdprb-w-80 tdprb-p-3 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-disabled"><?php echo esc_html( get_option('tdprb-access-token-val') ); ?></label>
                        <!-- <input type="text" class="tdprb-p-2 tdprb-w-80 tdprb-disabled" id="tdprb_api_key" name="tdprb_settings[api_key]" value="<?php //echo esc_attr( $options['api_key'] ); ?>" class="regular-text" readonly> -->
                        <button class="tdprb-w-20 tdprb-bg-dark-blue tdprb-rounded-md tdprb-cursor-pointer tdprb-text-white tdprb-fs-14 tdprb-fw-500 tdprb-border-0" id="tdprb-access-token-action" data-activate="<?php echo ( get_option('tdprb-access-token-val' )  != '' ) ? '0' : '1'; ?>">
                            <?php echo esc_html__('Deactivate', 'tdp-ring-builder'); ?>
                        </button>
                    </div>
                </div>
            </div>
            <?php if( get_option('tdprb-access-token-val') != '' ) { ?>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label for="tdprb_shortcode" class="tdprb-fs-18 tdprb-fw-700">Shortcode</label>
                    </div>
                    <div class="tdprb-w-60 tdprb-h-100px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex">
                        <div class="tdprb-d-flex tdprb-w-100 tdprb-gap-2 tdprb-justify-start tdprb-align-center tdprb-fs-14 tdprb-fw-500">
                            <div class="copy-info">Click on the field to copy the code</div>
                            <input type="text" value="[Ring_Builder]" class="tdprb-input-field tdprb-copy-input-field tdprb-cursor-pointer tdprb-p-2 tdprb-text-center" readonly />
                            <div id="copy-notify" style="display:none;">Copied!</div>
                        </div>
                    </div>
                </div>
            <?php } ?>                    
            <div class="">
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label for="Both-diamond" class="tdprb-fs-18 tdprb-fw-700">Default Diamond Type</label>
                    </div>
                    <div class="tdprb-w-60 tdprb-h-100px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-justify-start tdprb-align-center tdprb-gap-5 ">
                        <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                            <input name="tdprb_settings[default_type]" type="radio" value="both" id="Both-diamond" <?php checked( $options['default_type'], 'both' ); ?>>
                            <label for="Both-diamond">Both</label>
                        </div>
                        <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                            <input name="tdprb_settings[default_type]" type="radio" value="natural" id="Natural-diamond" <?php checked( $options['default_type'], 'natural' ); ?>>
                            <label for="Natural-diamond">Natural</label>
                        </div>
                        <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                            <input name="tdprb_settings[default_type]" type="radio" value="lab-grown" id="Lab-grown-diamond" <?php checked( $options['default_type'], 'lab-grown' ); ?>>
                            <label for="Lab-grown-diamond">Lab-grown</label>
                        </div>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40 tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700" for="Normal-Layout">Layout</label>
                    </div>
                    <div class="tdprb-w-60 tdprb-h-100px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-justify-start tdprb-align-center tdprb-gap-5">
                        <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                            <input name="tdprb_settings[layout]" type="radio" value="normal" id="Normal-Layout" <?php checked( $options['layout'], 'normal' ); ?>>
                            <label for="Normal-Layout">Normal</label>
                        </div>
                        <div class="tdprb-d-flex tdprb-justify-center tdprb-h-100 tdprb-cursor-pointer tdprb-align-center tdprb-gap-2 tdprb-fs-14 tdprb-fw-500">
                            <input name="tdprb_settings[layout]" type="radio" value="boxy" id="Boxy-Layout" <?php checked( $options['layout'], 'boxy' ); ?>>
                            <label for="Boxy-Layout">Boxy</label>
                        </div>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40 tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700" for="bg-color">Colors</label>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-grid tdprb-grid-cols-3 tdprb-gap-5">
                       
                            <div class="tdprb-w-100 tdprb-d-flex tdprb-justify-start tdprb-align-start tdprb-gap-3 tdprb-flex-column">
                                <label class="tdprb-fs-14 tdprb-fw-500" for="background-color">Background Color</label>
                                <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                    <input type="text" id="background-color" name="tdprb_settings[theme_colors][background]" value="<?php echo esc_attr( $options['theme_colors']['background'] ); ?>" class="tdprb-color-field">     
                                </section>
                            </div>

                            <div class="tdprb-w-100 tdprb-d-flex tdprb-justify-start tdprb-align-start tdprb-gap-3 tdprb-flex-column">
                                <label class="tdprb-fs-14 tdprb-fw-500" for="theme-color">Theme Color</label>
                                <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                    <input type="text" id="theme-color" name="tdprb_settings[theme_colors][theme]" value="<?php echo esc_attr( $options['theme_colors']['theme'] ); ?>" class="tdprb-color-field">     
                                </section>
                            </div>

                            <div class="tdprb-w-100 tdprb-d-flex tdprb-justify-start tdprb-align-start tdprb-gap-3 tdprb-flex-column">
                                <label class="tdprb-fs-14 tdprb-fw-500" for="border-color">Border Color</label>
                                <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                    <input type="text" id="border-color" name="tdprb_settings[theme_colors][border]" value="<?php echo esc_attr( $options['theme_colors']['border'] ); ?>" class="tdprb-color-field">     
                                </section>
                            </div>

                            <div class="tdprb-w-100 tdprb-d-flex tdprb-justify-start tdprb-align-start tdprb-gap-3 tdprb-flex-column">
                                <label class="tdprb-fs-14 tdprb-fw-500" for="text1-color">Text1 Color</label>
                                <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                    <input type="text" id="text1-color" name="tdprb_settings[theme_colors][text1]" value="<?php echo esc_attr( $options['theme_colors']['text1'] ); ?>" class="tdprb-color-field">     
                                </section>
                            </div>

                            <div class="tdprb-w-100 tdprb-d-flex tdprb-justify-start tdprb-align-start tdprb-gap-3 tdprb-flex-column">
                                <label class="tdprb-fs-14 tdprb-fw-500" for="text2-color">Text2 Color</label>
                                <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                    <input type="text" id="text2-color" name="tdprb_settings[theme_colors][text2]" value="<?php echo esc_attr( $options['theme_colors']['text2'] ); ?>" class="tdprb-color-field">     
                                </section>
                            </div>
                       
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40 tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700" for="book-appointment-links">Manage Links</label>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                        <div class="tdprb-w-100 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border-b tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="book-appointment-links">Details Page</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2 tdprb-gap-3">
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="book-appointment-link">Book an Appointment Link</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[details_page_links][book_appointment_link]" id="book-appointment-link" value="<?php echo esc_attr( $options['details_page_links']['book_appointment_link'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="virtual-consultation-link">Virtual Consultation Link</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[details_page_links][virtual_consultation_link]" id="virtual-consultation-link" value="<?php echo esc_attr( $options['details_page_links']['virtual_consultation_link'] ); ?>">
                                </article>
                            </section>
                        </div>
                        <div class="tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border-b tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="product-advertisement-link">Product Advertisement Link</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2 tdprb-gap-3">

                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100" for="diamond-details-ad">Diamond Details Ad (1:1 or 16:9 recommended)</label>
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[product_advertisement_links][diamond_details_ad][link]" id="diamond-details-ad" value="<?php echo esc_attr( $options['product_advertisement_links']['diamond_details_ad']['link'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100 " for="diamond-details-ad-redirect">Diamond Details Ad Redirection</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[product_advertisement_links][diamond_details_ad][redirect_link]" id="diamond-details-ad-redirect" value="<?php echo esc_attr( $options['product_advertisement_links']['diamond_details_ad']['redirect_link'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="setting-details-ad">Setting Details Ad (1:1 or 16:9 recommended)</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[product_advertisement_links][setting_details_ad][link]" id="setting-details-ad" value="<?php echo esc_attr( $options['product_advertisement_links']['setting_details_ad']['link'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="setting-details-ad-redirect">Setting Details Ad Redirection</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[product_advertisement_links][setting_details_ad][redirect_link]" id="setting-details-ad-redirect" value="<?php echo esc_attr( $options['product_advertisement_links']['setting_details_ad']['redirect_link'] ); ?>">
                                </article>
                               
                            </section>
                        </div>
                        <div class="tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="diamond-list-detail-ad">List Advertisement Link</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-3 tdprb-gap-3">
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="diamond-list-ad-link">Diamond List Ad</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[list_advertisement_links][diamond_list_ad][link]" id="diamond-list-ad-link" value="<?php echo esc_attr( $options['list_advertisement_links']['diamond_list_ad']['link'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="diamond-list-ad-redirect-link">Diamond List Ad Redirection</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[list_advertisement_links][diamond_list_ad][redirect_link]" id="diamond-list-ad-redirect-link" value="<?php echo esc_attr( $options['list_advertisement_links']['diamond_list_ad']['redirect_link'] ) ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="diamond-list-ad-interval">Interval</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_settings[list_advertisement_links][diamond_list_ad][interval]" id="diamond-list-ad-interval" value="<?php echo esc_attr( $options['list_advertisement_links']['diamond_list_ad']['interval'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="setting-list-ad-link">Setting List Ad</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[list_advertisement_links][setting_list_ad][link]" id="setting-list-ad-link" value="<?php echo esc_attr( $options['list_advertisement_links']['setting_list_ad']['link'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="setting-list-ad-redirect-link">Diamond List Ad Redirection</label>     
                                    <input class="tdprb-w-100" type="url" name="tdprb_settings[list_advertisement_links][setting_list_ad][redirect_link]" id="setting-list-ad-redirect-link" value="<?php echo esc_attr( $options['list_advertisement_links']['setting_list_ad']['redirect_link'] ) ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="setting-list-ad-interval">Interval</label>     
                                    <input class="tdprb-w-100" type="number" name="tdprb_settings[list_advertisement_links][setting_list_ad][interval]" id="setting-list-ad-interval" value="<?php echo esc_attr( $options['list_advertisement_links']['setting_list_ad']['interval'] ); ?>">
                                </article>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40 tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700" for="translations">Translations</label>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                        <div class="tdprb-w-100 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border-b tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="header-text">Header Text</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2 tdprb-gap-3">
                               
                                <article class="tdprb-w-100 tdprb-d-flex  tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="header-diamond">Diamond</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[header_texts][diamond][primary]" id="header-diamond" value="<?php echo esc_attr( $options['header_texts']['diamond']['primary'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex  tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="header-diamond">Choose your Diamond</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[header_texts][diamond][secondary]" id="header-diamond" value="<?php echo esc_attr( $options['header_texts']['diamond']['secondary'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex  tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="header-setting">Setting</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[header_texts][setting][primary]" id="header-setting" value="<?php echo esc_attr( $options['header_texts']['setting']['primary'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex  tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="header-choose-setting">Choose your Setting</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[header_texts][setting][secondary]" id="header-choose-setting" value="<?php echo esc_attr( $options['header_texts']['setting']['secondary'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex  tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="header-compelte-ring">Complete Ring</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[header_texts][complete_ring][primary]" id="header-compelte-ring" value="<?php echo esc_attr( $options['header_texts']['complete_ring']['primary'] ); ?>">
                                </article>

                                <article class="tdprb-w-100 tdprb-d-flex  tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="header-choose-compelte-ring">Choose your Setting</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[header_texts][complete_ring][secondary]" id="header-choose-compelte-ring" value="<?php echo esc_attr( $options['header_texts']['complete_ring']['secondary'] ); ?>">
                                </article>
                                            
                            </section>
                        </div>
                        <div class="tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border-b tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="tabs-text">Tabs Text</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                <article class="tdprb-w-100 tdprb-d-flex  tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="tab-natural">Natural Diamond</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[tabs_texts][natural_diamonds]" id="tab-natural" value="<?php echo esc_attr( $options['tabs_texts']['natural_diamonds'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex  tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="tab-lab">Lab Grown Diamond</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[tabs_texts][lab_grown_diamonds]" id="tab-lab" value="<?php echo esc_attr( $options['tabs_texts']['lab_grown_diamonds'] ); ?>">
                                </article> 
                            </section>
                        </div>
                        <div class="tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border-b tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="diamond-details-text">Diamond details Text</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                               
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="diamond-cart">Add to cart</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[diamond_texts][add_to_cart]" id="diamond-cart" value="<?php echo esc_attr( $options['diamond_texts']['add_to_cart'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="diamond-select">Select this Diamond</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[diamond_texts][select_this_setting]" id="diamond-select" value="<?php echo esc_attr( $options['diamond_texts']['select_this_setting'] ); ?>">
                                </article>  
                                
                            </section>
                        </div>
                        <div class="tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border-b tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="setting-details-text">Setting details Text</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="setting-cart">Add to cart</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[setting_texts][add_to_cart]" id="setting-cart" value="<?php echo esc_attr( $options['setting_texts']['add_to_cart'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="setting-select">Select this Diamond</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[setting_texts][select_this_setting]" id="setting-select" value="<?php echo esc_attr( $options['setting_texts']['select_this_setting'] ); ?>">
                                </article>  
                            </section>
                        </div>
                        <div class="tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border-b tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="product-details-text">Product details page Texts</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-3  tdprb-gap-3">
                                
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="product-detail-text1">Text1</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[product_detail_texts][text1]" id="product-detail-text1" value="<?php echo esc_attr( $options['product_detail_texts']['text1'] ); ?>">
                                </article> 
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="product-detail-text1">Text2</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[product_detail_texts][text2]" id="product-detail-text1" value="<?php echo esc_attr( $options['product_detail_texts']['text2'] ); ?>">
                                </article> 
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="product-detail-text1">Text3</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[product_detail_texts][text3]" id="product-detail-text1" value="<?php echo esc_attr( $options['product_detail_texts']['text3'] ); ?>">
                                </article> 
                                
                        </div>
                        <div class="tdprb-w-100 tdprb-min-h-50px tdprb-p-4 tdprb-bg-gray tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <h3 class="tdprb-fs-26 tdprb-fw-700 tdprb-lh-2" for="complete-text">Complete Ring Texts</h3>
                            <section class="tdprb-w-100 tdprb-d-grid tdprb-grid-cols-2  tdprb-gap-3">
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="complete-rings-texts">Complete Ring Text</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[complete_rings_texts][complete_rings_texts]" id="complete-rings-texts" value="<?php echo esc_attr( $options['complete_rings_texts']['complete_rings_texts'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="order-summary">Order Summary</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[complete_rings_texts][order_summary]" id="order-summary" value="<?php echo esc_attr( $options['complete_rings_texts']['order_summary'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="checkout-button-text">Checkout Button Text</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[complete_rings_texts][checkout_button_text]" id="checkout-button-text" value="<?php echo esc_attr( $options['complete_rings_texts']['checkout_button_text'] ); ?>">
                                </article>
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100  " for="ring-size-text">Ring Size Text</label>     
                                    <input class="tdprb-w-100" type="text" name="tdprb_settings[complete_rings_texts][ring_size_text]" id="ring-size-text" value="<?php echo esc_attr( $options['complete_rings_texts']['ring_size_text'] ); ?>">
                                </article>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="tdprb-w-100 tdprb-d-flex tdprb-gap-4 tdprb-border-b tdprb-py-4">
                    <div class="tdprb-w-40  tdprb-p-4">
                        <label class="tdprb-fs-18 tdprb-fw-700" for="translations">Inline CSS</label>
                    </div>
                    <div class="tdprb-w-60 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border tdprb-border-gray-medium tdprb-shape-view-shadow tdprb-rounded-lg tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                        <div class="tdprb-w-100 tdprb-min-h-50px  tdprb-p-4 tdprb-bg-gray tdprb-border-b tdprb-border-gray-medium-light tdprb-d-flex tdprb-flex-column tdprb-gap-2">
                            <section class="tdprb-w-100">
                                <article class="tdprb-w-100 tdprb-d-flex tdprb-flex-column tdprb-gap-3">
                                    <label class="tdprb-text-left tdprb-fs-14 tdprb-fw-500 tdprb-w-100 " for="inline_css">Inline CSS</label>
                                    <input type="hidden" name="inline_css" id="inline_css_value" value="<?php echo esc_textarea($options['inline_css']['value']); ?>"/>
                                    <textarea id="inline_css" name="tdprb_settings[inline_css][value]" rows="10" cols="50" class="tdprb-w-100"><?php echo esc_textarea($options['inline_css']['value']); ?></textarea>
                                </article>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tdp-submit-button tdprb-d-flex tdprb-justify-end tdprb-w-100">
            <?php submit_button( __( 'Save Settings', 'tdp-ring-builder' ) ); ?>
        </div>
    </form>
</div>