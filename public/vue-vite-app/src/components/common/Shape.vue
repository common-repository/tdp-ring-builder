<template>
  <div :class="containerClass">
    <label v-if="isLoading" v-for="(shape, index) in shapeNames" :key="index" :class="loadingLabelClass">
      <div :class="loadingShapeClass"></div>
    </label>
    <label v-else v-for="(shape, index) in shapeNames" :key="shape.key" :title="shape.value.toUpperCase()"
      :class="shapeLabelClass" :for="shape.key">
      <input type="radio" v-model="selectedShape" :value="shape.key" :id="shape.key" hidden />
      <div :class="shapeContainerClass(shape.key)">
        <div class="tdprb-aspect-square tdprb-shape-image tdprb-scale-90"
          v-html="getShape(shape.key, selectedShape == shape.key)" />
      </div>
      <div v-if="!isNormalLayout"
        class="tdprb-h-[30%] tdprb-w-full tdprb-text-center tdprb-text-ellipsis tdprb-overflow-hidden">
        <span
          class="tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[18px] tdprb-font-Lato tdprb-text-textSecondaryColor tdprb-text-ellipsis">
          {{ toSentenceCase(shape.value) }}
        </span>
      </div>
    </label>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedShape: '',
      shapeNames: [],
      isSettingPage: false,
      isLoading: false,
      isNormalLayout: false,
    };
  },
  created() {
    this.initializeShape();
  },
  computed: {
    layoutType() {
      return this.$store.getters['generalSettings/getGeneralSettingByKey']('layout');
    },
    getFilterData() {
      return this.$store.getters[this.getFilterKey + '/getFilterData']('shape');
    },
    getFilterValue() {
      return this.$store.getters[this.getFilterKey + '/getFilterValue']('shape');
    },
    getFilterKey() {
      return this.isSettingPage ? 'settingFilters' : 'diamondFilters';
    },
    containerClass() {
      return this.isNormalLayout
        ? 'tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-[10px] tdprb-flex-nowrap tdprb-overflow-x-auto tdprb-overflow-y-hidden tdprb-custom-scrollbar'
        : 'tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-auto tdprb-flex-wrap tdprb-overflow-x-hidden tdprb-gap-[15px] tdprb-max-h-[300px] tdprb-overflow-y-auto';
    },
    loadingLabelClass() {
      return this.isNormalLayout ? 'tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-items-center tdprb-justify-center tdprb-cursor-pointer tdprb-rounded-lg'
        : 'md:tdprb-w-[100px] tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-cursor-pointer';
    },
    loadingShapeClass() {
      return 'tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[50px] tdprb-w-[50px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape tdprb-skeleton-loader';
    },
    shapeLabelClass() {
      return this.isNormalLayout ? 'tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-items-center tdprb-justify-center tdprb-cursor-pointer'
        : 'md:tdprb-w-[100px] tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-cursor-pointer';
    },
    shapeContainerClass() {
      return (shapeName) => `tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[60px] tdprb-w-[60px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape ${shapeName === this.selectedShape ? 'tdprb-bg-themeColor' : ''}`;
    },
    toSentenceCase() {
      return (value) => this.$toSentenceCase(value);
    }
  },
  methods: {
    getShape(shapeName, isActive) {
      return this.$getDiamondShapes(shapeName, isActive);
    },
    async initializeShape() {
      this.selectedShape = this.getFilterValue;
    },
    updateQueryString(name, value) {
      if (name && value) {
        const query = { ...this.$route.query, [name]: value };
        this.$router.push({ query });
      }
    },
    updateFilter(filter, value) {
      this.$store.dispatch(`${this.getFilterKey}/updateFilterValue`, { filter, value });
    },
  },
  watch: {
    layoutType: {
      immediate: true,
      handler(newVal) {
        this.isNormalLayout = newVal === 'normal';
      }
    },
    '$route.name': {
      immediate: true,
      handler(val) {
        this.isSettingPage = ['SettingDetailPage', 'SettingListPage'].includes(val);
      }
    },
    selectedShape: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.updateFilter('shape', newVal);
          !this.isSettingPage && this.updateQueryString('shape', newVal);
        }
      }
    },
    getFilterData: {
      immediate: true,
      handler(newVal) {
        if (newVal.length) {
          this.shapeNames = newVal
        }
      }
    },
    getFilterValue: {
      immediate: true,
      handler(newVal) {
          this.selectedShape = newVal
      }
    }
  }
};
</script>
