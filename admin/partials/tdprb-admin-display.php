<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.thediamondport.com
 * @since      1.0.0
 *
 * @package    TDP_Ring_Builder
 * @subpackage TDP_Ring_Builder/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$tdprb_api_key = sanitize_text_field( get_option('tdprb-access-token-val') );
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="tdprb-wrap">
    <div class="tdprb-row tdprb-bg">
        <div class="tdprb-col-4">
            <div class="tdprb-left-main">
                <div class="tdprb-access-token-section">
                    <div class="tdprb-inner">
                        <div class="tdprb-inner-heading">
                            <h2><?php echo esc_html__('API Key to TDP Ring Creator', 'tdp-ring-builder'); ?></h2>
                            <p><?php echo esc_html__('Provide a vaild token to api key The Ring Creator settings', 'tdp-ring-builder'); ?></p>
                        </div>
                        <div class="tdprb-inner-content">
                            <input  type="text" 
                                    id="tdprb-api-key"
                                    class="regular-text"
                                    placeholder="<?php echo esc_html__('Enter your API key', 'tdp-ring-builder'); ?>"
                                    value="<?php echo esc_attr( get_option('tdprb-access-token-val') ); ?>"
                            />
                            <button id="tdprb-access-token-action" class="button button-primary tdprb-bg-dark-blue" data-activate="<?php if( get_option('tdprb-access-token-val') != '' ) { ?>0<?php } else { ?>1<?php } ?>">
                                <?php if( get_option('tdprb-access-token-val') != '' ) { ?>
                                    <?php echo esc_html__('Deactivate Token', 'tdp-ring-builder'); ?>
                                <?php } else { ?>
                                    <?php echo esc_html__('Activate Token', 'tdp-ring-builder'); ?>
                                <?php } ?>
                            </button>
                        </div>
                        <div id="tdprb-access-token-notify"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
