import { createRouter, createWebHistory } from 'vue-router';
import { useStore } from 'vuex';

// Import page components
import Homepage from '../pages/index.vue';
import ErrorPage from '../pages/errors/index.vue';
import DiamondListPage from '../pages/diamonds/index.vue';
import SettingListPage from '../pages/settings/index.vue';
import CompleteRingPage from '../pages/complete-ring/index.vue';
import DiamondDetailPage from '../pages/diamonds/DetailPage.vue';
import SettingDetailPage from '../pages/settings/DetailPage.vue';

import { slugs } from '../utils/variables';
import { toSentenceCase } from '../utils/functions';

// Helper function to process URL and remove slugs
const processUrl = (url, slugs) => slugs.reduce((processedUrl, slug) => {
  const index = processedUrl.indexOf(slug);
  return index !== -1 ? processedUrl.slice(0, index - 1) : processedUrl;
}, url);

// Helper functions to serialize and deserialize query parameters
const serializeStateToQueryString = (state) => {
  const store = useStore();
  const { diamond_type, shape } = state;
  
  const diamondTypeValue = diamond_type.value || diamond_type.data[0];
  const shapeValue = Array.isArray(shape.value) && shape.value.length ? shape.value[0] : shape.value || shape.data[0];

  const diamond_type_final = diamond_type.data.includes(diamondTypeValue) ? diamondTypeValue : diamond_type.data[0] || 'natural';
  const shape_final = shape.data.includes(toSentenceCase(shapeValue)) ? shapeValue : shape.data[0] || 'round';

  const query = new URLSearchParams({ type: diamond_type_final, shape: shape_final });

  store.dispatch('diamondFilters/updateFilterValue', { filter: 'diamond_type', value: diamond_type_final });
  store.dispatch('diamondFilters/updateFilterValue', { filter: 'shape', value: shape_final });

  return query.toString();
};

const deserializeQueryStringToState = (query) => {
  const params = new URLSearchParams(query);
  return {
    type: params.get('type'),
    shape: params.get('shape'),
  };
};

const baseUrl = processUrl(window.location.pathname, slugs);

// Define route configurations
const routes = [
  {
    path: "/",
    name: "Home",
    component: Homepage,
    beforeEnter: (to, from, next) => {
      next({ name: 'DiamondListPage' });
    },
  },
  {
    path: "/diamond-list",
    name: "DiamondListPage",
    component: DiamondListPage,
    beforeEnter: (to, from, next) => {
      const store = useStore();
      const state = store.state.diamondFilters.diamond.filters;
      let { type, shape } = deserializeQueryStringToState(to.query);

      if (type && shape) {
        type = type.toLowerCase().replace(/\s+/g).replace(/-/g, "");

        const matchingTypes = state.diamond_type.data || [];
        const matchingShapes = state.shape?.data.map(item => item.key) || [];

        if (!matchingTypes.includes(type)) {
          type = matchingTypes[0] || 'natural';
        }
        if (!matchingShapes.includes(shape)) {
          shape = matchingShapes[0] || 'round';
        }
        
        store.dispatch('diamondFilters/updateFilterValue', { filter: 'diamond_type', value: type });
        store.dispatch('diamondFilters/updateFilterValue', { filter: 'shape', value: shape });
        next();
      } else {
        const queryString = serializeStateToQueryString(state);
        next({ path: to.path, query: deserializeQueryStringToState(queryString), replace: true });
      }
    },
  },
  {
    path: "/diamond-details/:type/:id",
    name: "DiamondDetailPage",
    component: DiamondDetailPage,
  },
  {
    path: "/settings",
    name: "SettingListPage",
    component: SettingListPage,
  },
  {
    path: "/setting-details/:id",
    name: "SettingDetailPage",
    component: SettingDetailPage,
  },
  {
    path: "/complete-ring",
    name: "CompleteRingPage",
    component: CompleteRingPage,
    beforeEnter: (to, from, next) => {
      const store = useStore();
      const diamond = store.getters['completeRing/getDiamondData'];
      const setting = store.getters['completeRing/getSettingData'];

      if (diamond && setting && Object.keys(diamond).length && Object.keys(setting).length) {
        next(); 
      } else if (diamond && Object.keys(diamond).length) {
        next({ name: 'SettingListPage' });
      } else {
        next({ name: 'DiamondListPage' });
      }
    },
  },
  {
    path: "/:catchAll(.*)",
    name: "ErrorPage",
    component: ErrorPage,
  },
];

// Create and export the Vue Router instance
export const router = createRouter({
  history: createWebHistory(baseUrl),
  routes,
});
