const state = {
    filters: [],              // Stores the basic filters
    detailsCustomization: [],   // Diamond Details Customization Visibility
    advertisements: {},
    product_image	:{},
    location_status	:null,
    locations	 :{},
    ring_size	:null,
  };
  
  const mutations = {
    SET_FILTERS(state, filters) {
      state.filters = filters;
    },
 
    SET_SETTING_DETAIL_CUSTOMIZATION(state, payload) {
      state.detailsCustomization = payload;      
    },

    SET_ADVERTISEMENTS(state, payload) {
      state.advertisements = payload;
    },
    SET_PRODUCT_IMAGE(state, payload) {
      state.product_image = payload;
    },
    SET_LOCATION_STATUS(state, payload) {
      state.location_status = payload;
    },
    SET_LOCATIONS(state, payload) {
      state.locations = payload;
    },
    SET_RING_SIZE(state, payload) {
      state.ring_size = payload;
    },
   
  };

  const actions = {
    processFilterData({ commit, dispatch }, data) {
      const filters = data.filter(filter => filter.status === 'show');

      data.forEach((filter) => {
        if (filter.status === 'show') {
          const itemsText = filter.items
            .filter(item => item.status === 'show' && item.text !== 'All') // Filter items with status 'show'
            .map(item => filter.key == "shape" ? item : item.value); // Extract the text value

          if (itemsText.length > 0) {
            // Dispatch the action to another store module dynamically
            dispatch('settingFilters/updateFilterData', { filter : filter.key, data: itemsText }, { root: true });
          }
        }
      });
      commit('SET_FILTERS', filters);
    },
    processFilterLimits({ commit, dispatch }, data) {
      // Extract the keys and sort them
        const sortedKeys = Object.keys(data).sort();

        // Loop through the sorted keys and dispatch an action for each key-value pair
        sortedKeys.forEach(key => {
          const value = data[key];

          // for min value
          if (value.hasOwnProperty(`${key}_min`)) {
            const min = value[`${key}_min`];
            dispatch('settingFilters/updateFilterMin', { filter: key, min: min }, { root: true });
          }

          // for max value
          if (value.hasOwnProperty(`${key}_max`)) {
            const max = value[`${key}_max`];
            dispatch('settingFilters/updateFilterMax', { filter: key, max: max }, { root: true });
          }

          // for steps value
          if (value.hasOwnProperty(`${key}_stepper`)) {
            const stepper = value[`${key}_stepper`];
            dispatch('settingFilters/updateFilterSteps', { filter: key, steps: stepper }, { root: true });
          }
          
        });
    },
    setAdvertisements({ commit }, payload) {
      commit('SET_ADVERTISEMENTS', payload);
    },
    setProductImage({ commit }, payload) {
      commit('SET_PRODUCT_IMAGE', payload);
    },
    setLocationStatus({ commit }, payload) {
      commit('SET_LOCATION_STATUS', payload);
    },
    setLocations({ commit }, payload) {
      commit('SET_LOCATIONS', payload);
    },
    setRingSize({ commit }, payload) {
      commit('SET_RING_SIZE', payload);
    },
    processDetailsCustomization({ commit, dispatch }, data) {
      
      // Filter objects with status 'show'
      const filteredItems = data?.filter(item => item.status === 'show');
  
      // Commit the filtered items if needed
      commit('SET_SETTING_DETAIL_CUSTOMIZATION', filteredItems);
    },
  };
    
  
  const getters = {
    filters: (state) => state.filters,
    setAdvertisements: (state) => state.advertisements,
    detailsCustomization: (state) => state.detailsCustomization,
    productImage: (state) => state.product_image,
    locationStatus: (state) => state.location_status,
    locations: (state) => state.locations,
    ringSize: (state) => state.ring_size,
  };
  
  export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
  };
  