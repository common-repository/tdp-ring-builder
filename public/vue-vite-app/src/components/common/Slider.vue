<template>
  <div>
    <div class="tdprb-flex tdprb-items-center tdprb-w-full tdprb-justify-center tdprb-align-center tdprb-relative">
      <!-- Ticks -->
      <span v-if="data?.length" v-for="(item, index) in data" :key="index"
        :class="['tdprb-absolute', 'tdprb-select-none', 'tdprb-text-backgroundColor', 'tdprb-font-[800]', 'tdprb-text-[16px]', 'tdprb-z-[2]', 'tdprb-flex', 'tdprb-items-center', 'tdprb-justify-center', (index + 1 === value[0] || index === value[1] - 1) ? 'tdprb-opacity-0' : '']"
        :style="{ left: getStepSliderTicksCal(index + 1, data.length) + '%' }">
        |
      </span>

      <!-- Range Slider -->
      <div class="tdprb-w-full">
        <vue-slider v-model="value" :interval="steps" :dragOnClick="true" :adsorb="true" :enable-cross="false"
          tooltip="none" :min-range="steps" :min="Number(min)" :max="Number(max)" ref="slider">
        </vue-slider>
      </div>
    </div>

    <!-- Labels -->
    <div v-if="data.length > 0" class="tdprb-w-full">
      <ul class="tdprb-m-0 tdprb-w-full tdprb-grid" :style="{ gridTemplateColumns: `repeat(${data.length}, 1fr)` }">
        <li v-for="(item, index) in data" :key="index"
          class="tdprb-w-full tdprb-flex tdprb-items-center tdprb-justify-center tdprb-capitalize tdprb-text-textSecondaryColor tdprb-font-lato tdprb-font-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-h-[36px]">
          {{ getFullForm(item) }}
        </li>
      </ul>
    </div>

    <!-- Input Fields -->
    <div v-else class="tdprb-mt-3 tdprb-w-full tdprb-flex tdprb-justify-between">
      <input type="number"
        class="tdprb-bg-backgroundColor tdprb-text-textSecondaryColor tdprb-font-lato tdprb-font-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-border tdprb-border-borderColor tdprb-rounded tdprb-w-[130px] tdprb-h-[36px] tdprb-px-4 tdprb-text-left"
        v-model.number="value[0]" @keyup.enter="onFocusOut($event, 'min')" :min="min" :max="max" @focusin="onInputEnter"
        @focusout="onFocusOut($event, 'min')" />
      <input type="number"
        class="tdprb-bg-backgroundColor tdprb-text-textSecondaryColor tdprb-font-lato tdprb-font-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-border tdprb-border-borderColor tdprb-rounded tdprb-w-[130px] tdprb-h-[36px] tdprb-px-4 tdprb-text-left"
        v-model.number="value[1]" @keyup.enter="onFocusOut($event, 'max')" :min="min" :max="max" @focusin="onInputEnter"
        @focusout="onFocusOut($event, 'max')" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    filterType: String,
    tooltips: {
      type: Boolean,
      default: false
    },
  },
  data() {
    return {
      data: [],
      value: [],
      min: null,
      max: null,
      steps: null,
      isSettingPage: false,
      settingSlugs: ['SettingDetailPage', 'SettingListPage']
    };
  },
  computed: {
    getAllFilters() {
      return this.isSettingPage
        ? this.$store.getters['settingFilters/getAllFilters']
        : this.$store.getters['diamondFilters/getAllFilters'];
    },
    getFilterValue() {
      return this.isSettingPage
        ? this.$store.getters['settingFilters/getFilterValue'](this.filterType)
        : this.$store.getters['diamondFilters/getFilterValue'](this.filterType);
    },
  },
  created() {

    this.isSettingPage = this.settingSlugs.includes(this.$route.name);
    const filter = this.getAllFilters[this.filterType];

    if (filter) {
      if (filter.data && filter.data.length > 0) {
        this.min = 0;
        this.max = filter.data.length;
        this.steps = 1;
        this.data = filter.data;
      } else {
        this.min = Number(filter.min);
        this.max = Number(filter.max);
        if (!isNaN(this.min) && !isNaN(this.max) && !isNaN(filter.steps) && filter.steps > 0) {
          const range = this.max - this.min;
          let stepSize = range / filter.steps;
          this.steps = (range % stepSize === 0) ? Number(filter.steps) : 1;
        } else {
          this.steps = 1;
        }
      }
      this.value = this.getFilterValue?.length ? this.getFilterValue : [this.min, this.max];
    }
  },
  methods: {
    getFullForm(item) {
      const matching = ["cut",
        "polish",
        "symmetry",]
      if (matching.includes(this.filterType)) {
        return this.$getCutSymmetryPolishFullForm(item);
      } else {
        return item
      }
    },
    onInputEnter(e) {
      e.target.value = ""
    },
    onFocusOut(e, type) {
      if (e.target.value == "") {
        if (type === 'min') {
          e.target.value = this.value[0]
        } else if (type === 'max') {
          e.target.value = this.value[1]
        }
      }
      // Ensure the left input value does not exceed the right input value
      if (this.value[0] > this.value[1]) {
        this.value[1] = this.value[0];
      }

      // Ensure values are within the specified bounds
      this.value[0] = Math.max(this.min, Math.min(this.value[0], this.value[1]));
      this.value[1] = Math.max(this.value[0], Math.min(this.value[1], this.max));


      // Set the slider value
      this.$refs.slider.setValue(this.value);
      e.target.blur();
    },
    getStepSliderTicksCal(i, n) {
      return this.$getStepSliderTicks(i, n);
    },
    updateFilterValue(filter, value) {
      const action = this.isSettingPage
        ? 'settingFilters/updateFilterValue'
        : 'diamondFilters/updateFilterValue';
      this.$store.dispatch(action, { filter, value });
    },

  },
  watch: {
    '$route.name'(val) {
      this.isSettingPage = this.settingSlugs.includes(val);
    },
    getFilterValue: {
      handler(val) {
        if (val.length) {
          this.value = val;
        }
      },
      immediate: true,
      deep: true
    },
    value: {
      handler(val) {
        if (val) {
          this.updateFilterValue(this.filterType, val);
        }
      },
      deep: true
    },
  }
};
</script>

<style>
.vue-slider-process {
  background-color: var(--theme-color) !important;
}

.vue-slider-dot {
  height: 20px !important;
  width: 20px !important;
}

.vue-slider-dot-handle {
  background-color: var(--theme-color) !important;
  box-shadow: none !important;
}

.vue-slider.vue-slider-ltr {
  height: 3px !important;
}
</style>
