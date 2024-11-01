const mutations = {
  SET_FILTER_DATA(state, { filter, data }) {
    state.setting.filters[filter].data = data;
  },
  SET_FILTER_VALUE(state, { filter, value }) {
    state.setting.filters[filter].value = value;
  },
  SET_FILTER_MIN(state, { filter, min }) {
    if (state.setting.filters[filter].min !== undefined) {
      state.setting.filters[filter].min = min;
    }
  },
  SET_FILTER_MAX(state, { filter, max }) {
    if (state.setting.filters[filter].max !== undefined) {
      state.setting.filters[filter].max = max;
    }
  },
  SET_FILTER_STEPS(state, { filter, steps }) {
    if (state.setting.filters[filter].steps !== undefined) {
      state.setting.filters[filter].steps = steps;
    }
  },
  SET_SETTING_DATA(state, data) {
    state.setting.data = data;
  },
  RESET_FILTERS(state) {
    Object.keys(state.setting.filters).forEach(filter => {
      const filterObject = state.setting.filters[filter];
      const matching = [
        'items_per_row',
        'per_page',
        'is_image',
        'locations',
      ]
      if (!matching.includes(filter)) {
        if (filter == 'current_page') {
          filterObject.value = 1;
        }else if (filter == 'shape') {
          filterObject.value = null;
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
  updateFilterData({ commit }, payload) {
    commit("SET_FILTER_DATA", payload);
  },
  updateFilterValue({ commit }, payload) {
    commit("SET_FILTER_VALUE", payload);
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
  updateSettingData({ commit }, data) {
    commit("SET_SETTING_DATA", data);
  },
  resetFilters({ commit }) {
    commit("RESET_FILTERS");
  },
};

const getters = {
  getFilterValue: (state) => (filter) => {
    return state.setting.filters[filter].value;
  },
  getFilterData: (state) => (filter) => {
    return state.setting.filters[filter].data;
  },
  getFilterMin: (state) => (filter) => {
    return state.setting.filters[filter].min;
  },
  getFilterMax: (state) => (filter) => {
    return state.setting.filters[filter].max;
  },
  getFilterSteps: (state) => (filter) => {
    return state.setting.filters[filter].steps;
  },
  getAllFilters: (state) => {
    return state.setting.filters;
  },
  getSettingData: (state) => {
    return state.setting.data;
  },
};

export default {
  namespaced: true,
  state: () => ({
    setting: {
      filters: {
        items_per_row :{
          value: null,
          data:null,
        },
        locations :{
          value: null,
          data:null,
        },
        per_page :{
          value: null,
          data:null,
        },
        is_image :{
          value: null,
          data:null,
        },
        current_page :{
          value: 1,
          data:1,
        },
        shape: {
          value: null,
          data: [],
        },
        metal: {
          value: null,
          data: [],
        },
        ring_style: {
          value: null,
          data: [],
        },
        price: {
          value: [],
          min: null,
          max: null,
          steps: null,
        },
        sort_field: {
          value: 1,
          data: [1,2,3],
        },
      },
      data: [],
    },
  }),
  mutations,
  actions,
  getters,
};
