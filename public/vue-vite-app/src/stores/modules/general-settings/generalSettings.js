const state = () => ({
  generalSettings: {
    api_key: null,
    default_type: null,
    layout: null,
    complete_rings_texts: {},
    details_page_links: {},
    diamond_texts: {},
    header_texts: {},
    inline_css: {},
    list_advertisement_links: {},
    product_advertisement_links: {},
    product_detail_texts: {},
    setting_texts: {},
    tabs_texts: {},
    theme_colors: {},
  }
});

const mutations = {
  SET_GENERAL_SETTINGS(state, settings) {
    state.generalSettings = settings;
  },
  UPDATE_SETTING_BY_KEY(state, { key, subKey, value }) {
    if (state.generalSettings[key] && typeof state.generalSettings[key] === 'object') {
      state.generalSettings[key][subKey] = value;
    }
  }
};

const actions = {
  setGeneralSettings({ commit }, settings) {
    commit('SET_GENERAL_SETTINGS', settings);
  },
  updateSettingByKey({ commit }, { key, subKey, value }) {
    commit('UPDATE_SETTING_BY_KEY', { key, subKey, value });
  }
};

const getters = {
  getGeneralSettings: (state) => state.generalSettings,
  getGeneralSettingByKey: (state) => (key) => state.generalSettings[key],
};

export default {
  namespaced: true, // Enable namespacing
  state,
  mutations,
  actions,
  getters,
};
