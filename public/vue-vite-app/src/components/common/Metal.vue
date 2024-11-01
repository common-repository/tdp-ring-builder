<template>
  <div v-if="isNormalLayout"
    class="tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-auto tdprb-flex-nowrap tdprb-overflow-x-auto tdprb-overflow-y-hidden tdprb-custom-scrollbar"
    :class="!!gap ? `tdprb-gap-[${gap}px]` : 'tdprb-gap-[5px]'">
    <label v-if="isLoading"
      class="tdprb-min-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px] tdprb-cursor-pointer"
      v-for="(shape, index) in shapeNames" :key="shape">
      <div
        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[50px] tdprb-w-[50px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape tdprb-relative tdprb-skeleton-loader">
      </div>
    </label>
    <label v-else :title="shape.toUpperCase()"
      class="tdprb-min-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px] tdprb-cursor-pointer"
      v-for="(shape, index) in shapeNames" :key="index" :for="shape">
      <input type="radio" v-model="selectedShape" :value="shape" :id="shape" hidden />
      <div
        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[50px] tdprb-w-[50px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape tdprb-relative">
        <!-- Image Content -->
        <div v-html="getMetals(shape, shape == selectedShape)"></div>
        <!-- Carat Text Overlay -->
        <div
          class="tdprb-absolute  tdprb-w-full tdprb-text-center tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-textPrimaryColor">
          {{ separateNameAndCarat(shape).carat }}
        </div>
      </div>
      <!-- <div v-if="isLabel" class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-text-center">{{
        separateNameAndCarat(shape).name }}</div> -->
    </label>
  </div>
  <div v-else
    class="tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-auto tdprb-flex-nowrap tdprb-overflow-x-auto tdprb-overflow-y-hidden tdprb-custom-scrollbar"
    :class="!!gap ? `tdprb-gap-[${gap}px]` : 'tdprb-gap-[30px]'">
    <label v-if="isLoading"
      class="tdprb-min-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px] tdprb-cursor-pointer"
      v-for="(shape, index) in shapeNames" :key="shape">
      <div
        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[50px] tdprb-w-[50px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape tdprb-relative tdprb-skeleton-loader">
      </div>
    </label>
    <label v-else
      class="tdprb-min-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px] tdprb-cursor-pointer"
      v-for="(shape, index) in shapeNames" :key="index" :for="shape">
      <input type="radio" v-model="selectedShape" :value="shape" :id="shape" hidden />
      <div
        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[50px] tdprb-w-[50px] tdprb-aspect-square tdprb-rounded-lg tdprb-shape tdprb-relative">
        <!-- Image Content -->
        <div v-html="getMetals(shape, shape == selectedShape)"></div>
        <!-- Carat Text Overlay -->
        <div
          class="tdprb-absolute  tdprb-w-full tdprb-text-center tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-textPrimaryColor">
          {{ separateNameAndCarat(shape).carat }}
        </div>
      </div>
      <div v-if="isLabel" class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-text-center">{{
        separateNameAndCarat(shape).name }}</div>
    </label>
  </div>
</template>

<script>

export default {
  props: {
    isLabel: {
      type: Boolean,
      default: true,
    },
    selectedMetal: {
      type: String,
      default: null,
    },
    filterType: {
      type: String,
    },
    gap: {
      type: Number,
    },

  },
  emits: ['update'],
  data() {
    return {
      shapeNames: [],
      selectedShape: null,
      isLoading: false,
      isNormalLayout: false,

    };
  },
  created() {
    this.selectedShape = !!this.selectedMetal ? this.selectedMetal : this.getFilterValue
  },
  computed: {
    getFilterData() {
      return this.$store.getters['settingFilters/getFilterData']('metal');
    },
    getFilterValue() {
      return this.$store.getters['settingFilters/getFilterValue']('metal');
    },
    layoutType() {
      return this.$store.getters['generalSettings/getGeneralSettingByKey']('layout');
    },
  },
  methods: {
    getMetals(metal, isActive) {
      return this.$getMetals(metal, isActive)
    },
    separateNameAndCarat(fullname) {
      return this.$separateCaratAndName(fullname)
    },
    updateFilter(filter, value) {
      this.$store.dispatch('settingFilters/updateFilterValue', { filter, value });
    }
  },
  watch: {
    layoutType: {
      immediate: true,
      deep: true,
      handler(newVal) {
        if (!!newVal) {
          this.isNormalLayout = newVal === 'normal';
        }
      }
    },
    shapeNames: {
      immediate: true,
      deep: true,
      handler(newVal) {
        if (!!newVal && newVal?.length > 0) {
          this.isLoading = false;
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
    getFilterValue: {
      deep: true,
      handler(newVal) {
        this.selectedShape = newVal
      }
    },
    selectedShape: {
      immediate: true,
      deep: true,
      handler(newVal) {
        if (!!newVal) {
          if (this.selectedMetal) {
            this.$emit('update', newVal);
          } else {
            this.updateFilter('metal', newVal)
          }
        }
      }
    },
  }
};
</script>