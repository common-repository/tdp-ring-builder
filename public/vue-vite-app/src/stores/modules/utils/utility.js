export default {
    namespaced: true,
  
    state: () => ({
      data: {}, // Store all data here
    }),
  
    getters: {
      getData: (state) => (key) => {
        return state.data[key];
      },
      getAllData: (state) => {
        return state.data;
      }
    },
  
    mutations: {
      SET_DATA(state, { key, value }) {
        state.data[key] = value;
      },
      UPDATE_DATA(state, { key, value }) {
        state.data[key] = { ...state.data[key], ...value };
      },
      RESET_DATA(state, key) {
        if (key) {
          delete state.data[key];
        } else {
          state.data = {};
        }
      }
    },
  
    actions: {
      setData({ commit }, payload) {
        commit('SET_DATA', payload);
      },
      updateData({ commit }, payload) {
        commit('UPDATE_DATA', payload);
      },
      resetData({ commit }, key) {
        commit('RESET_DATA', key);
      }
    }
  };
  