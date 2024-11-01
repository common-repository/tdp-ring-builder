<template>
  <div class="md:tdprb-py-[30px] tdprb-py-[15px] tdprb-my-0 tdprb-mx-auto tdprb-min-h-[100vh] tdprb-max-w-[1680px] tdprb-bg-backgroundColor">
    <Loader :isMainLoader="true" v-if="isLoading" containerClass="tdprb-h-screen" />
    <Error v-else-if="isError.status" :message="isError.message" containerClass="tdprb-h-screen" />
    <template v-else>
      <Navigation />
      <Homepage />
    </template>
  </div>
</template>
<script>
import Navigation from "./components/Navigation.vue";
import Homepage from "./pages/index.vue";
export default {
  components: {
    Navigation,
    Homepage,
  },
  data() {
    return {
      isError: {
        status: false,
        message: '',
      },
    };
  },
  computed: {
    diamondType() {
      return this.$store.getters['diamondFilters/getFilterValue']('diamond_type');
    },
    isLoading() {
      return this.$store.getters['allConfigApi/isLoading'];
    },
    configData() {
      return this.$store.getters['allConfigApi/getData'];
    },
  },
  methods: {
    async fetchInitialData() {
      await this.$store.dispatch('allConfigApi/fetchData', this.$domain + this.$apiEndpoints.allConfigApi);
      this.processConfigData(this.configData);
    },
    updateStore(module, action, payload) {
      this.$store.dispatch(`${module}/${action}`, payload);
    },
    processGeneralSettings(settings) {
      this.updateStore('generalSettings', 'setGeneralSettings', settings);
      if (settings.theme_colors) {
        this.$updateCSSVariables(settings.theme_colors);
      }
      // if (settings.inline_css?.value) {
      //   this.$addDynamicCSS(settings.inline_css.value);
      // }
      if (settings.default_type) {
        const type = settings.default_type.toLowerCase().replace(/\s+/g).replace(/-/g, "");
        if (type == 'both') {
          if (!!this.diamondType) {
            const matchingTypes = ['natural', 'labgrown']
            if (matchingTypes.includes(this.diamondType)) {
              this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'diamond_type', value: this.diamondType });
            } else {
              this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'diamond_type', value: 'natural' });
            }
          } else {
          }
        } else {
          this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'diamond_type', value: type });
        }
      }
    },
    processDiamondSettings(type, settings) {
      this.updateStore('diamondSettings', 'setDefaultView', settings.default_view);
      this.updateStore('diamondSettings', 'setGridView', settings.show_grid_view);
      this.updateStore('diamondSettings', 'setListView', settings.show_list_view);
      let selectedLocations = Object.keys(settings.locations).filter(key => settings.locations[key] === "1");
      this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'locations', value: selectedLocations });
      this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'is_image', value: settings.product_with_image == '1' ? '2' : '' });
      this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'is_video', value: settings.product_with_video == '1' ? '1' : '' });
      this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'per_page', value: settings.page_size });
      this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'diamond_title', value: settings.diamond_title });
      this.updateStore('diamondFilters', 'updateFilterValue', { filter: 'items_per_row', value: settings.items_per_row });
      this.updateStore('diamondSettings', 'processListViewCustomization', settings.list_view_customization);
      this.updateStore('diamondSettings', 'processFilterData', settings.search_filters);
      this.updateStore('diamondSettings', 'processFilterLimits', settings.search_limits);
      this.updateStore('diamondSettings', 'processDiamondDetailsCustomization', settings.diamond_details_customization);
    },
    processRingSettings(settings) {
      let selectedLocations = Object.keys(settings.locations).filter(key => settings.locations[key] === "1");
      this.updateStore('settingFilters', 'updateFilterValue', { filter: 'locations', value: selectedLocations });
      this.updateStore('settingFilters', 'updateFilterValue', { filter: 'per_page', value: settings.page_size });
      this.updateStore('settingFilters', 'updateFilterValue', { filter: 'is_image', value: settings.product_with_image });
      this.updateStore('settingFilters', 'updateFilterValue', { filter: 'items_per_row', value: settings.items_per_row });
      this.updateStore('settingSettings', 'processFilterData', settings.search_filters);
      this.updateStore('settingSettings', 'processFilterLimits', settings.search_limits);
      this.updateStore('settingSettings', 'processDetailsCustomization', settings.details_customization);
      this.updateStore('settingSettings', 'setProductImage', settings.product_image);
      this.updateStore('settingSettings', 'setLocationStatus', settings.location_status);
      this.updateStore('settingSettings', 'setLocations', settings.locations);
      this.updateStore('settingSettings', 'setRingSize', settings.ring_size);
    },
    processConfigData(data, isSession = false) {
      if (!data) {
        this.isError = { status: true, message: 'No configuration data available!' };
        return;
      }

      if (!isSession) {
        this.processGeneralSettings(data.general_settings);
      }

      const diamondSettings = this.diamondType === 'labgrown' ? data.labgrown_settings : data.natural_settings;
      if (diamondSettings) {
        this.processDiamondSettings(this.diamondType || data.general_settings.default_type, diamondSettings);
      }

      if (data.ring_settings) {
        this.processRingSettings(data.ring_settings);
      }

      this.isError = { status: false, message: '' };
    },
  },
  watch: {
    diamondType: {
      handler(newType) {
        if (newType && this.configData) {
          this.processConfigData(this.configData, true);
        }
      },
      immediate: true,
    },
  },
  created() {
    this.fetchInitialData();
  },
};
</script>
