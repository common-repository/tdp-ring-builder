<template>
  <div>
    <span
      class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-poppins tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[21px] tdprb-text-left tdprb-text-themeColor">Shape:
      {{ selectedShape }}</span>
  </div>
  <div :class="containerClass">
    <label v-for="(shape, index) in shapeNames" :key="shape" :title="shape" :class="shapeLabelClass" :for="shape">
      <input type="radio" v-model="selectedShape" :value="shape" :id="shape" hidden />
      <div :class="shapeContainerClass(shape)">
        <div class="tdprb-aspect-square tdprb-shape-image tdprb-scale-90"
          v-html="getShape(shape, selectedShape == shape)" />
      </div>
    </label>
  </div>
</template>

<script>
export default {
  props: {
    selectedShape: {
      type: String,
      default: ''
    },
    shapes: {
      type: String,
      default: ''
    }
  },
  emits: ["update"],
  data() {
    return {
      selectedShape: '',
      shapeNames: [],
    };
  },
  computed: {
    containerClass() {
      return 'tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-auto tdprb-flex-nowrap tdprb-overflow-x-auto tdprb-overflow-y-hidden tdprb-custom-scrollbar tdprb-gap-[5px]'
    },
    loadingLabelClass() {
      return 'tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-items-center tdprb-justify-center tdprb-cursor-pointer tdprb-rounded-lg';

    },
    shapeLabelClass() {
      return 'tdprb-w-[60px] tdprb-aspect-square tdprb-flex tdprb-items-center tdprb-justify-center tdprb-cursor-pointer';
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
  },
  watch: {
    shapes: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.shapeNames = newVal.split(',').map(d => this.$setting_can_be_set_with_shapes[d - 1]) || [];
        }
      }
    },
    selectedShape: {
      immediate: true,
      handler(newVal) {
        if (newVal) {
          this.$emit('update', newVal)
        }
      }
    },
  }
};
</script>
