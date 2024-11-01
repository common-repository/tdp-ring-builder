// store/modules/filters.js

const state = {
    filters: [],              // Stores the basic filters
    AdvancedFilters: [],      // Stores the advanced filters
    isAdvancedFilter: false,   // Toggles advanced filters visibility
    defaultView: null,   // Toggles default view visibility
    show_grid_view: null,
    show_list_view: null,
    diamondDetailsCustomization: [],   // Diamond Details Customization Visibility
    listViewCustomization: {},   // Diamond Details Customization Visibility
    advertisements: {},
    diamondTitle: null,
  };
  
  const mutations = {
    SET_FILTERS(state, filters) {
      state.filters = filters;
    },
    SET_ADVANCED_FILTERS(state, advancedFilters) {
      state.AdvancedFilters = advancedFilters;
    },
    SET_IS_ADVANCED_FILTER(state, payload) {
      state.isAdvancedFilter = payload;
    },
    SET_DEFAULT_VIEW(state, payload) {
      state.defaultView = payload;
    },
    SET_GRID_VIEW(state, payload) {
      state.show_grid_view = payload;
    },
    SET_LIST_VIEW(state, payload) {
      state.show_list_view = payload;
    },
    SET_ADVERTISEMENTS(state, payload) {
      state.advertisements = payload;
    },
    SET_DIAMOND_TITLE(state, payload) {
      state.diamondTitle = payload;
    },
    SET_DIAMOND_DETAIL_CUSTOMIZATION(state, payload) {
      state.diamondDetailsCustomization = payload;      
    },
    SET_DIAMOND_LIST_VIEW_CUSTOMIZATION(state, payload) {
      state.listViewCustomization = payload;      
    }
  };

  const actions = {
    processFilterData({ commit, dispatch }, data) {
      const filters = data.filter(filter => filter.status === 'show' && !filter.advancefilter);
      const advancedFilters = data.filter(filter => filter.status === 'show' && filter.advancefilter);
  
      const filteredItems = {}; // Object to store the key-value pairs
  
      data.forEach((filter) => {
        if (filter.status === 'show') {
          const itemsText = filter.items
          .filter(item => item.status === 'show' && item.text !== 'All') // Filter items with status 'show' and text not equal to 'All'
          .map(item =>  filter.key == "shape" ? item : item.value); // Map the remaining items to their value

          if (itemsText.length > 0 && itemsText) {
            filteredItems[filter.key] = itemsText; // Store in the object with key as filter.key

            // Dispatch the action to another store module dynamically
            dispatch('diamondFilters/updateFilterData', { filter : filter.key, value: itemsText }, { root: true });
          }
        }
      });
  
      commit('SET_FILTERS', filters);
      commit('SET_ADVANCED_FILTERS', advancedFilters);
    },
    processFilterLimits({ commit, dispatch }, data) {
      // Extract the keys and sort them
        const sortedKeys = Object.keys(data).sort();

        // Loop through the sorted keys and dispatch an action for each key-value pair
        sortedKeys.forEach(key => {
          const value = data[key];
          const min = Number(value[`${key}_min`]) || 0;
          const max = Number(value[`${key}_max`]) || 100;
          const stepper = Number(value[`${key}_stepper`]) || 1;

          // for min value
          if (value.hasOwnProperty(`${key}_min`)) {
            dispatch('diamondFilters/updateFilterMin', { filter: key, min: min }, { root: true });
          }

          // for max value
          if (value.hasOwnProperty(`${key}_max`)) {
            dispatch('diamondFilters/updateFilterMax', { filter: key, max: max }, { root: true });
          }

          // for steps value
          if (value.hasOwnProperty(`${key}_stepper`)) {
            dispatch('diamondFilters/updateFilterSteps', { filter: key, steps: stepper }, { root: true });
          }
          
        });
    },
    setAdvancedFilter({ commit }, payload) {
      commit('SET_IS_ADVANCED_FILTER', payload);
    },
    setDefaultView({ commit }, payload) {
      commit('SET_DEFAULT_VIEW', payload);
    },
    setListView({ commit }, payload) {
      commit('SET_LIST_VIEW', payload);
    },
    setGridView({ commit }, payload) {
      commit('SET_GRID_VIEW', payload);
    },
    setAdvertisements({ commit }, payload) {
      commit('SET_ADVERTISEMENTS', payload);
    },
    setDiamondTitle({ commit }, payload) {
      commit('SET_DIAMOND_TITLE', payload);
    },
    processDiamondDetailsCustomization({ commit, dispatch }, data) {
      // Filter objects with status 'show'
      const filteredItems = data.filter(item => item.status === 'show');
  
      // Commit the filtered items if needed
      commit('SET_DIAMOND_DETAIL_CUSTOMIZATION', filteredItems);
    },
    processListViewCustomization({ commit, dispatch }, data) {
      // Filter items with status 'show' and map to their text values
      const filteredItems = data
        .filter(item => item.status === 'show') // Filter out items with status 'show'
      // Commit the filtered items if needed
      commit('SET_DIAMOND_LIST_VIEW_CUSTOMIZATION', filteredItems);
    }
    
  
  };
    
  
  const getters = {
    filters: (state) => state.filters,
    AdvancedFilters: (state) => state.AdvancedFilters,
    getIsAdvancedFilter: (state) => state.isAdvancedFilter,
    getDefaultView: (state) => state.defaultView,
    getGridView: (state) => state.show_grid_view,
    getListView: (state) => state.show_list_view,
    setAdvertisements: (state) => state.advertisements,
    setDiamondTitle: (state) => state.diamondTitle,
    diamondDetailsCustomization: (state) => state.diamondDetailsCustomization,
    listViewCustomization: (state) => state.listViewCustomization
  };
  
  export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
  };
  