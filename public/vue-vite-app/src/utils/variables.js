export const isDevelopmentMode =  process.env.NODE_ENV === "development" 
export const domain = isDevelopmentMode ? 'http://tdp-plugins.com' : window.location.origin
export const defaultAjaxUrl = `${domain}/wp-admin/admin-ajax.php`;
export const slugs = ['diamond-list', 'diamond-details', 'settings', 'setting-details', 'complete-ring']
export const apiEndpoints = {
    allConfigApi: '/wp-json/tdp-rb/v1/front-data',
}

export const apiActions = {
    diamondListApi:'tdprb_diamond_list_ajax',
    diamondDetailsApi:'tdprb_diamond_details_ajax',
    ringListApi:'tdprb_rings_list_ajax',
    ringDetailsApi:'tdprb_ring_details_ajax',
    diamondAddToCartApi:'tdprb_loosediamond_add_to_cart',
    settingAddToCartApi:'tdprb_loosering_add_to_cart',
    completeRingAddToCartApi:'tdprb_completering_add_to_cart',
}

export const setting_can_be_set_with_shapes = ['Round', 'Princess', 'Cushion', 'Radiant', 'Asscher', 'Emerald', 'Oval', 'Pear', 'Marquise', 'Heart'];





