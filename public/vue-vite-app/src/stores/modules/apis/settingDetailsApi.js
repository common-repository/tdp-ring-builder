import axios from 'axios';
import { apiActions,isDevelopmentMode,defaultAjaxUrl } from '../../../utils/variables';

const state = () => ({
  settingData: {},
  all_metals: {},
  loading: false,
  dataNotFound: false,
  dataNotFoundMsg: '',
  cancelTokenSource: null, // New state for cancel token
});

const getters = {
  settingData: (state) => state.settingData,
  all_metals: (state) => state.all_metals,
  loading: (state) => state.loading,
  dataNotFound: (state) => state.dataNotFound,
  dataNotFoundMsg: (state) => state.dataNotFoundMsg,
};

const mutations = {
  SET_SETTING_DATA(state, data) {
    state.settingData = data;
  },
  SET_ALL_METAL_DATA(state, data) {
    state.all_metals = data;
  },
  SET_LOADING(state, isLoading) {
    state.loading = isLoading;
  },
  SET_DATA_NOT_FOUND(state, { dataNotFound, dataNotFoundMsg = '' }) {
    state.dataNotFound = dataNotFound;
    state.dataNotFoundMsg = dataNotFoundMsg;
  },
  SET_CANCEL_TOKEN_SOURCE(state, source) {
    state.cancelTokenSource = source;
  },
};

const actions = {
  async fetchSettingDetail({ commit, state }, { id }) {
    // Cancel previous API call if it's still pending
    if (state.cancelTokenSource) {
      state.cancelTokenSource.cancel('Operation canceled due to a new request.');
    }

    const cancelTokenSource = axios.CancelToken.source();
    commit('SET_CANCEL_TOKEN_SOURCE', cancelTokenSource);
    commit('SET_LOADING', true);

    const actionUrl = isDevelopmentMode ? defaultAjaxUrl : tdprbajax.ajaxurl;
    const data = new FormData();
    data.append('action', apiActions.ringDetailsApi);
    !isDevelopmentMode && data.append("nonce", tdprbajax.nonce);
    data.append('sku', id);

    try {
      const response = await axios.post(actionUrl, data, {
        cancelToken: cancelTokenSource.token,
      });

      if (response.data.data.success) {
        const settingData = response.data.data.data[0] || {};
        sessionStorage.setItem('tdpx-setting-meta-data', JSON.stringify(settingData));
        commit('SET_SETTING_DATA', settingData);
        commit('SET_ALL_METAL_DATA', settingData.all_metal);
        commit('SET_DATA_NOT_FOUND', { dataNotFound: false });
      } else {
        commit('SET_SETTING_DATA', {});
        commit('SET_ALL_METAL_DATA', {});
        commit('SET_DATA_NOT_FOUND', { dataNotFound: true, dataNotFoundMsg: response.data.data.message });
      }
    } catch (error) {
      if (!axios.isCancel(error)) {
        commit('SET_SETTING_DATA', {});
        commit('SET_ALL_METAL_DATA', {});
        commit('SET_DATA_NOT_FOUND', { dataNotFound: true, dataNotFoundMsg: 'An error occurred while fetching data.' });
      }
    } finally {
      commit('SET_LOADING', false);
    }
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};