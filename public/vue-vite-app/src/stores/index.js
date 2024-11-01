import { createStore } from 'vuex';

// Import Vuex modules
import diamondFilters from './modules/diamonds/diamondFilters';
import settingFilters from './modules/settings/settingFilters';
import generalSettings from './modules/general-settings/generalSettings.js';
import diamondSettings from './modules/diamonds/diamondSettings';
import settingSettings from './modules/settings/settingSettings';
import allConfigApi from './modules/apis/allConfigApi';
import diamondDetailsApi from './modules/apis/diamondDetailsApi';
import diamondListApi from './modules/apis/diamondListApi';
import settingDetailsApi from './modules/apis/settingDetailsApi';
import settingListApi from './modules/apis/settingListApi';
import completeRing from './modules/complete-ring/completeRing.js';
import utility from './modules/utils/utility.js';

// Create a Vuex plugin to persist store modules
function persistModules(store) {
  const storageMap = [
    { storage: window.sessionStorage, modules: [
        'diamondFilters',
        'settingFilters',
        // 'allConfigApi',
        // 'diamondDetailsApi',
        // 'diamondListApi',
        // 'settingDetailsApi',
        // 'settingListApi',
        'generalSettings',
        'diamondSettings',
        'settingSettings',
        'utility'
      ] 
    },
    { storage: window.localStorage, modules: [
        'completeRing',
      ] 
    }
  ];

  // Rehydrate store from storage and subscribe to mutations
  storageMap.forEach(({ storage, modules }) => {
    modules.forEach(moduleName => {
      const storedModule = storage.getItem(moduleName);
      if (storedModule) {
        store.replaceState({
          ...store.state,
          [moduleName]: JSON.parse(storedModule)
        });
      }

      store.subscribe((mutation, state) => {
        if (mutation.type.startsWith(`${moduleName}/`)) {
          storage.setItem(moduleName, JSON.stringify(state[moduleName]));
        }
      });
    });
  });
}

// Create and configure Vuex store with the persistence plugin
const store = createStore({
  modules: {
    diamondFilters,
    settingFilters,
    generalSettings,
    diamondSettings,
    settingSettings,
    allConfigApi,
    diamondDetailsApi,
    diamondListApi,
    settingDetailsApi,
    settingListApi,
    completeRing,
    utility
  },
  plugins: [persistModules] // add the persistence plugin
});

export default store;
