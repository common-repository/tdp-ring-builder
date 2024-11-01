import { createApp } from 'vue';
import './style.css';
import App from './App.vue';
import store from './stores';
import { router } from './routes';

import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'


// Import utilities and variables
import { 
   filterString
,getBaseUrlFromSession
,toSentenceCase
,setSessionData
,getSessionData
,removeSessionData
,removeAllSessionData
,updateCSSVariables
,addDynamicCSS
,isEmpty
,getCutFullForm
,setSymbol
,backToTop
,getStepSliderTicks
,separateCaratAndName
,getRingSizesByCountry
,increasePriceByPercentage
,roundToTwoDecimals
,getSubsetFromRange
,getImageFromAssets
,getNavigationBarIcon
,getColors
,getDiamondShapes
,getRingStyles
,getMetals
,getFancyColors
,sanitizeText
,getDiamondTooltipText
,getSettingTooltipText
,getCutSymmetryPolishFullForm

} from './utils/functions';

import { domain,
    slugs,
    apiEndpoints,
    apiActions,
    defaultAjaxUrl,
    isDevelopmentMode,
    setting_can_be_set_with_shapes
} from './utils/variables';

// Import common components
import Slider from './components/common/Slider.vue';
import Dropdown from './components/common/Dropdown.vue';
import Loader from './components/common/Loader.vue';
import Tooltip from './components/common/Tooltip.vue';
import Error from './components/common/Error.vue';
import Alert from './components/common/Alert.vue';
import DefaultImage from './components/common/DefaultImage.vue';
import LabelComp from './components/common/LabelComp.vue';
import MiniLoader from './components/common/MiniLoader.vue';
import Skeleton from "./components/common/Skeleton.vue"
import DiamondAdvertisementCard from "./components/diamonds/DiamondAdvertisementCard.vue"
import SettingAdvertisementCard from "./components/settings/SettingAdvertisementCard.vue"


// Import filter
import DiamondType from './components/diamonds/DiamondType.vue';
import Shape from './components/common/Shape.vue';
import FancyColor from './components/common/FancyColor.vue';
import Metal from './components/common/Metal.vue';
import RingStyle from './components/common/RingStyle.vue';
import DiamondViewControls from './components/diamonds/DiamondViewControls.vue';
import SettingViewControls from './components/settings/SettingViewControls.vue';

// Import view components
import DiamondGridViewCard from './components/diamonds/DiamondGridViewCard.vue';
import SettingGridViewCard from './components/settings/SettingGridViewCard.vue';
import DiamondListView from './components/diamonds/DiamondListView.vue';
import SettingListView from './components/settings/SettingListView.vue';
import DiamondGridView from './components/diamonds/DiamondGridView.vue';
import SettingGridView from './components/settings/SettingGridView.vue';
import DiamondInfoTable from './components/diamonds/DiamondInfoTable.vue';
import SettingInfoTable from './components/settings/SettingInfoTable.vue';

// Import final ring components 
import DiamondProductCard from './components/complete-ring/DiamondProductCard.vue'
import SettingProductCard from './components/complete-ring/SettingProductCard.vue'
import OrderSummary from './components/complete-ring/OrderSummary.vue'
import DetailPageShape from './components/settings/DetailPageShape.vue';
import DetailPageMetal from './components/settings/DetailPageMetal.vue';

// Create Vue application
const app = createApp(App);

// Register plugins
app.use(store);
app.use(router);

// Register global components 
const components = { 
    VueSlider, 
    Slider, 
    Dropdown, 
    Loader, 
    MiniLoader,
    Skeleton,
    DefaultImage,
    DiamondAdvertisementCard,
    SettingAdvertisementCard,
    Tooltip, 
    Error,
    Alert ,
    DiamondType, 
    Shape, 
    Metal,
    RingStyle,
    FancyColor, 
    LabelComp, 
    DiamondViewControls,
    SettingViewControls ,
    SettingGridViewCard,
    DiamondGridViewCard,
    DiamondListView,
    SettingListView,
    DiamondGridView,
    SettingGridView, 
    DiamondInfoTable,
    SettingInfoTable,
    DiamondProductCard,
    SettingProductCard,
    OrderSummary,
    DetailPageShape,
    DetailPageMetal
};

Object.entries(components).forEach(([name, component]) => {
    app.component(name, component);
});


// Register global functions

const globalFunctions = {
    $filterString : filterString,
    $getBaseUrlFromSession : getBaseUrlFromSession,
    $toSentenceCase : toSentenceCase,
    $setSessionData : setSessionData,
    $getSessionData : getSessionData,
    $removeSessionData : removeSessionData,
    $removeAllSessionData : removeAllSessionData,
    $updateCSSVariables : updateCSSVariables,
    $addDynamicCSS : addDynamicCSS,
    $isEmpty : isEmpty,
    $getCutFullForm : getCutFullForm,
    $setSymbol : setSymbol,
    $backToTop : backToTop,
    $getStepSliderTicks : getStepSliderTicks,
    $separateCaratAndName : separateCaratAndName,
    $getRingSizesByCountry : getRingSizesByCountry,
    $increasePriceByPercentage : increasePriceByPercentage,
    $roundToTwoDecimals : roundToTwoDecimals,
    $getSubsetFromRange : getSubsetFromRange,
    $getImageFromAssets : getImageFromAssets,
    $getNavigationBarIcon : getNavigationBarIcon,
    $colors : getColors,
    $getDiamondShapes : getDiamondShapes,
    $getRingStyles : getRingStyles,
    $getMetals : getMetals,
    $getFancyColors : getFancyColors,
    $sanitizeText : sanitizeText,
    $getDiamondTooltipText : getDiamondTooltipText,
    $getSettingTooltipText : getSettingTooltipText,
    $getCutSymmetryPolishFullForm : getCutSymmetryPolishFullForm,
};

Object.entries(globalFunctions).forEach(([name, func]) => {
    app.config.globalProperties[name] = func;
});

// Register global variables

const globalVariables = {
   $domain : domain,
   $slugs : slugs,
   $apiEndpoints : apiEndpoints,
   $apiActions : apiActions,
   $defaultAjaxUrl : defaultAjaxUrl ,
   $isDevelopmentMode : isDevelopmentMode ,
   $setting_can_be_set_with_shapes : setting_can_be_set_with_shapes ,
}

Object.entries(globalVariables).forEach(([name, value]) => {
    app.config.globalProperties[name] = value;
});


// Mount the application
app.mount('#tdp-rb');
