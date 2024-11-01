const mutations = {
  SET_FILTER_VALUE(state, { filter, value }) {
      state.diamond.filters[filter].value  = value;
  },
  SET_FILTER_DATA(state, { filter, value }) {
    state.diamond.filters[filter].data  = value;
  },
  SET_FILTER_MIN(state, { filter, min }) {
    if (state.diamond.filters[filter].min  !== undefined) {
      state.diamond.filters[filter].min  = min;
    }
  },
  SET_FILTER_MAX(state, { filter, max }) {
    if (state.diamond.filters[filter].max  !== undefined) {
      state.diamond.filters[filter].max  = max;
    }
  },
  SET_FILTER_STEPS(state, { filter, steps }) {
    if (state.diamond.filters[filter].steps  !== undefined) {
      state.diamond.filters[filter].steps  = steps;
    }
  },
  SET_DIAMOND_DATA(state, data) {
    state.diamond.data = data;
  },
  RESET_FILTERS(state) {
    Object.keys(state.diamond.filters).forEach(filter => {
      const filterObject = state.diamond.filters[filter];
      const excluded = [
        'diamond_title',
        'items_per_row',
        'per_page',
        'diamond_type',
        'is_image',
        'is_video',
        'locations',
      ]
      if (!excluded.includes(filter)) {
        if (filter == 'current_page') {
          filterObject.value = 1;
        }else if (filter == 'shape') {
          filterObject.value = 'round';
        }else if (filter == 'sort_field'){
          filterObject.value = 1;
        }else{
            // Reset 'value' to its initial state
            if (Array.isArray(filterObject.value)) {
              if (filterObject.data && filterObject.data.length > 0) {
                filterObject.min = 0;
                filterObject.max = filterObject.data.length;
                filterObject.value = [filterObject.min, filterObject.max];
              }else{
                filterObject.value = [filterObject.min, filterObject.max];
              }
            } else if (typeof filterObject.value === 'object' && filterObject.value !== null) {
              filterObject.value = {};
            } else if (typeof filterObject.value === 'number') {
              filterObject.value = null;
            } else {
              filterObject.value = null;
            }
        }
      }

      // Reset 'min', 'max', 'steps', and 'data' to their initial states
      // if (filterObject.min !== undefined) filterObject.min = null;
      // if (filterObject.max !== undefined) filterObject.max = null;
      // if (filterObject.steps !== undefined) filterObject.steps = null;
      // if (filterObject.data !== undefined) filterObject.data = Array.isArray(filterObject.data) ? [] : null;
    });
  },
};

const actions = {
  updateFilterValue({ commit }, payload) {
    commit("SET_FILTER_VALUE", payload);
  },
  updateFilterData({ commit }, payload) {
    commit("SET_FILTER_DATA", payload);
  },
  updateFilterMin({ commit }, payload) {
    commit("SET_FILTER_MIN", payload);
  },
  updateFilterMax({ commit }, payload) {
    commit("SET_FILTER_MAX", payload);
  },
  updateFilterSteps({ commit }, payload) {
    commit("SET_FILTER_STEPS", payload);
  },
  updateDiamondData({ commit }, data) {
    commit("SET_DIAMOND_DATA", data);
  },
  resetFilters({ commit }) {
    commit("RESET_FILTERS");
  },
};

const getters = {
  getFilterValue: (state) => (filter) => {
    return state.diamond.filters[filter].value || null;
  },
  getFilterData: (state) => (filter) => {
    return state.diamond.filters[filter].data || null;
  },
  getFilterMin: (state) => (filter) => {
    return state.diamond.filters[filter].min || null;
  },
  getFilterMax: (state) => (filter) => {
    return state.diamond.filters[filter].max || null;
  },
  getFilterSteps: (state) => (filter) => {
    return state.diamond.filters[filter].steps || null;
  },
  getAllFilters: (state) => {
    return state.diamond.filters || null;
  },
  getDiamondData: (state) => {
    return state.diamond.data || null;
  },
};

export default {
  namespaced: true,
  state: () => ({
    diamond: {
      filters: {
        diamond_title :{
          value: null,
          data:null,
        },
        locations :{
          value: null,
          data:null,
        },
        is_image :{
          value: null,
          data:null,
        },
        is_video :{
          value: null,
          data:null,
        },
        items_per_row :{
          value: null,
          data:null,
        },
        per_page :{
          value: null,
          data:null,
        },
        current_page :{
          value: 1,
          data:1,
        },
        sort_field: {
          value: 1,
          data: [1,2,3],
        },
        diamond_type: {
          value: null,
          data: ['natural','labgrown','both'],
        },
        shape: {
          value: null,
          data: [],
        },
        fancy_color: {
          value: null,
          data: [],
        },
        color: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        carats: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        clarity: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        cut: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        depth_pr: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        fluorescence: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        l_w_ratio: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        lab: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        polish: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        price: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        symmetry: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
        table_pr: {
          data: [],
          value: [],
          min: null,
          max: null,
          steps: 1,
        },
      },
      data: [],
    },
  }),
  mutations,
  actions,
  getters,
};

