import axios from 'axios';
import { debounce } from '../../../utils/functions';
import { apiActions,isDevelopmentMode,defaultAjaxUrl } from '../../../utils/variables';
import { isEmpty, getSubsetFromRange } from '../../../utils/functions';

const state = () => ({
  data: [],
  dataCount: 0,
  currentPage: 1,
  lastPage: false,
  dataNotFound: false,
  dataNotFoundMsg: '',
  loading: false,
  loadMoreLoading: false,
  cancelTokenSource: null,
});

const getters = {
  data: (state) => state.data,
  dataCount: (state) => state.dataCount,
  currentPage: (state) => state.currentPage,
  lastPage: (state) => state.lastPage,
  dataNotFound: (state) => state.dataNotFound,
  dataNotFoundMsg: (state) => state.dataNotFoundMsg,
  loading: (state) => state.loading,
  loadMoreLoading: (state) => state.loadMoreLoading,
};

const mutations = {
  SET_DATA(state, data) {
    state.data = data;
  },
  APPEND_DATA(state, data) {
    state.data = [...state.data, ...data];
  },
  SET_DATA_COUNT(state, count) {
    state.dataCount = count;
  },
  SET_CURRENT_PAGE(state, page) {
    state.currentPage = page;
  },
  SET_LAST_PAGE(state, lastPage) {
    state.lastPage = lastPage;
  },
  SET_DATA_NOT_FOUND(state, { dataNotFound, dataNotFoundMsg }) {
    state.dataNotFound = dataNotFound;
    state.dataNotFoundMsg = dataNotFoundMsg;
  },
  SET_LOADING(state, loading) {
    state.loading = loading;
  },
  SET_LOAD_MORE_LOADING(state, loadMoreLoading) {
    state.loadMoreLoading = loadMoreLoading;
  },
  SET_CANCEL_TOKEN_SOURCE(state, source) {
    state.cancelTokenSource = source;
  },
};

const actions = {
  fetchSettingList: debounce(async function ({ commit, state }, { filters, type }) {
    const isOverride = type === 'override';

    if (state.cancelTokenSource) {
      state.cancelTokenSource.cancel('Operation canceled due to a new request.');
    }

    const cancelTokenSource = axios.CancelToken.source();
    commit('SET_CANCEL_TOKEN_SOURCE', cancelTokenSource);

    if (isOverride) {
      commit('SET_LOADING', true);
    } else {
      commit('SET_LOAD_MORE_LOADING', true);
    }

    commit('SET_CURRENT_PAGE', isOverride ? 1 : state.currentPage + 1);

    const actionUrl = isDevelopmentMode ? defaultAjaxUrl : tdprbajax.ajaxurl;
    const data = new FormData();
    data.append("action", apiActions.ringListApi);
    !isDevelopmentMode && data.append("nonce", tdprbajax.nonce);
    data.append("page", state.currentPage || 1);

    const filterMapping = {
      sort_field: "sort_field",
      price: "price",
      shape: "shape",
      metal: "metal",
      ring_style: "sub_category",
      per_page: "per_page",
      is_image: "is_image",
      locations: "country",
    };

    const simpleData = [
      'sub_category',
      'sort_field',
      'shape',
      'per_page',
      'metal',
      'is_image',
    ];

    Object.keys(filterMapping).forEach((key) => {
      const value = filters[key]?.value;
      const filterData = filters[key]?.data;

      if (key === 'locations' && Array.isArray(value) && value.length > 0) {
        data.append(filterMapping[key], value.join(","));
        return;
      }

      if (!isEmpty(value)) {
        let finalValue;

        if (simpleData.includes(filterMapping[key])) {
          finalValue = value;
        } else {
          if (!!filterData && Array.isArray(filterData) && filterData.length > 0) {
            if (value.length) {
              finalValue = getSubsetFromRange(filterData, value).join(",");
            }
          } else {
            finalValue = value.join("-");
          }
        }
        data.append(filterMapping[key], finalValue);
      } else {
        data.append(filterMapping[key], '');
      }
    });

    try {
      const response = await axios.post(actionUrl, data, { cancelToken: cancelTokenSource.token });
      commit(isOverride ? 'SET_LOADING' : 'SET_LOAD_MORE_LOADING', false);

      if (response.data.data.success) {
        const { data: fetchedData, total, last_page, currentPage, nextPageUrl } = response.data.data;
        if (fetchedData.length) {
          commit(isOverride ? 'SET_DATA' : 'APPEND_DATA', fetchedData);
          commit('SET_CURRENT_PAGE', currentPage);
          commit('SET_DATA_COUNT', total);
            if (state.data.length < total) {
              commit('SET_LAST_PAGE', false);
            }else{
              commit('SET_LAST_PAGE', true);
            }
          commit('SET_DATA_NOT_FOUND', { dataNotFound: false, dataNotFoundMsg: '' });
        } else {
          if (state.data.length <= total) {
            commit('SET_LAST_PAGE', true);
          }else{
            commit('SET_DATA_NOT_FOUND', { dataNotFound: true, dataNotFoundMsg: 'No Data Found!' });
          }
        }
      } else {
        if (state.data.length && !isOverride) {
          commit('SET_LAST_PAGE', true);
        }else{
          commit('SET_DATA', []);
          commit('SET_DATA_NOT_FOUND', { dataNotFound: true, dataNotFoundMsg: response.data.data.message });
        }
      }
    } catch (error) {
      commit(isOverride ? 'SET_LOADING' : 'SET_LOAD_MORE_LOADING', false);

      if (isOverride) {
        commit('SET_DATA', []);
        commit('SET_DATA_COUNT', 0);
        commit('SET_CURRENT_PAGE', 1);
      }

      if (!axios.isCancel(error)) {
        commit('SET_DATA_NOT_FOUND', { dataNotFound: true, dataNotFoundMsg: 'An error occurred while fetching data.' });
      } else {
        commit(isOverride ? 'SET_LOADING' : 'SET_LOAD_MORE_LOADING', true);
      }
    }
  }, 500), // Adjust the debounce delay as necessary (300ms is common)
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
