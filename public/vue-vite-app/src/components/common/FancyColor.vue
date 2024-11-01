<template>
  <div v-if="isNormalLayout"
    class="tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-[15px] tdprb-flex-nowrap tdprb-overflow-x-auto tdprb-overflow-y-hidden tdprb-custom-scrollbar">
    <label v-if="isLoading"
      class="tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-center tdprb-cursor-pointer tdprb-rounded-lg tdprb-skeleton-loader"
      v-for="(shape, index) in shapeNames" :key="shape">
    </label>
    <label v-else
      class="tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-center tdprb-cursor-pointer"
      v-for="(shape, index) in shapeNames" :key="index" :title="shape.toUpperCase()" :for="shape">
      <input type="radio" v-model="selectedShape" :value="shape" :id="shape" hidden />
      <div
        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[50px] tdprb-w-[50px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape"
        :class="selectedShape == shape && 'tdprb-bg-themeColor'">
        <div
          class="tdprb-h-[34px] tdprb-w-[34px] tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center"
          v-html="getFancyColors(shape,selectedShape == shape)"></div>
      </div>
      <!-- <div class="shape-label">{{ shape }}</div> -->
    </label>
  </div>
  <div v-else
    class="tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-auto tdprb-flex-nowrap tdprb-overflow-x-auto tdprb-overflow-y-hidden tdprb-custom-scrollbar">
    <label v-if="isLoading"
      class="tdprb-w-[100px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px] tdprb-cursor-pointer"
      v-for="(shape, index) in shapeNames" :key="shape">
      <div
        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[60px] tdprb-w-[60px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape tdprb-skeleton-loader">
      </div>
    </label>
    <label v-else
      class="tdprb-w-[100px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px] tdprb-cursor-pointer"
      v-for="(shape, index) in shapeNames" :key="index" :for="shape">
      <input type="radio" v-model="selectedShape" :value="shape" :id="shape" hidden />
      <div
        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[60px] tdprb-w-[60px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape"
        :class="selectedShape == shape && 'tdprb-bg-themeColor'">
        <div
          class="tdprb-h-[34px] tdprb-w-[34px] tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center"
          v-html="getFancyColors(shape,selectedShape == shape)"></div>
      </div>
      <div class="shape-label">{{ toSentenceCase(shape) }}</div>
    </label>
  </div>
</template>

<script>

export default {
  props: {
    filterType: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      shapeNames: [],
      selectedShape: null,
      isLoading: false,
      isNormalLayout: false,

    };
  },
  mounted() {
    this.selectedShape = this.getFilterValue;
  },
  computed: {
    layoutType() {
      return this.$store.getters['generalSettings/getGeneralSettingByKey']('layout');
    },
    getFilterData() {
      return this.$store.getters['diamondFilters/getFilterData']('fancy_color');
    },
    getFilterValue() {
      return this.$store.getters['diamondFilters/getFilterValue']('fancy_color');
    },
    toSentenceCase() {
      return (value) => {
        return this.$toSentenceCase(value);
      }
    }
  },
  methods: {
    getFancyColors(colorType, isActive) {
      return this.$getFancyColors(colorType, isActive)
    },
    updateFilter(filter, value) {
      this.$store.dispatch('diamondFilters/updateFilterValue', { filter, value });
    }
  },
  watch: {
    getFilterValue: {
      handler(newVal) {
        this.selectedShape = newVal;
      },
      immediate: true,
      deep: true,
    },
    layoutType: {
      immediate: true,
      deep: true,
      handler(newVal) {
        if (!!newVal) {
          this.isNormalLayout = newVal === 'normal';
        }
      }
    },
    getFilterData: {
      immediate: true,
      deep: true,
      handler(newVal) {
        if (newVal?.length > 0) {
          this.shapeNames = newVal
        }
      }
    },
    selectedShape: {
      immediate: true,
      deep: true,
      handler(newVal) {
        if (!!newVal) {
          this.updateFilter('fancy_color', newVal)
        }
      }
    },
    shapeNames: {
      immediate: true,
      deep: true,
      handler(newVal) {
        if (!!newVal) {
          this.isLoading = false;
        }
      }
    },
  }
};
</script>