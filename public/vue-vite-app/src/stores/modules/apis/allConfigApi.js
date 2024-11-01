const state = () => ({
    data: null,
    isLoading: true,
    error: null,
  });

  const mutations = {
    SET_DATA(state, payload) {
      state.data = payload;
    },
    SET_LOADING(state, isLoading) {
      state.isLoading = isLoading;
    },
    SET_ERROR(state, error) {
      state.error = error;
    },
  };

  
  import axios from 'axios';

const actions = {
  async fetchData({ commit }, endpoint) {
    commit('SET_LOADING', true);
    commit('SET_ERROR', null);

    try {
      const response = await axios.get(endpoint);
      commit('SET_DATA', response.data);
    } catch (error) {
      commit('SET_ERROR', error);
    } finally {
      commit('SET_LOADING', false);
    }
  },
};

const getters = {
    getData: (state) => state.data,
    isLoading: (state) => state.isLoading,
    getError: (state) => state.error,
  };

  export default {
    namespaced: true, // Enable namespacing
    state,
    mutations,
    actions,
    getters,
  };
  
  

  