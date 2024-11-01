const state = () => ({
    products: {
        diamond:{},
        setting:{},
    }
  });
  
  const mutations = {
    SET_DIAMOND_DATA(state, data) {
      state.products.diamond = data;
    },
    SET_SETTING_DATA(state, data) {
      state.products.setting = data;
    },
    REMOVE_DIAMOND_DATA(state) {
      state.products.diamond = {} ;
    },
    REMOVE_SETTING_DATA(state) {
      state.products.setting = {} ;
    },
  };
  
  const actions = {
    setDiamondData({ commit }, data) {
      commit('SET_DIAMOND_DATA', data);
    },
    setSettingData({ commit }, data) {
      commit('SET_SETTING_DATA', data);
    },
    removeDiamondData({ commit }) {
      commit('REMOVE_DIAMOND_DATA');
    },
    removeSettingData({ commit }) {
      commit('REMOVE_SETTING_DATA');
    },

  };
  
  const getters = {
    getDiamondData: (state) => state.products.diamond,
    getSettingData: (state) => state.products.setting,
    getProductsData: (state) => state.products,
  };
  
  export default {
    namespaced: true, // Enable namespacing
    state,
    mutations,
    actions,
    getters,
  };
  