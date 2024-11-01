<template>
  <div>
    <span
      class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-poppins tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[21px] tdprb-text-left tdprb-text-themeColor">Metal:
      {{ selectedShape }}</span>
  </div>
  <div
    class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-auto tdprb-flex-nowrap tdprb-overflow-x-auto tdprb-overflow-y-hidden tdprb-custom-scrollbar tdprb-gap-[5px]">

    <label :title="shape.toUpperCase()"
      class="tdprb-min-w-[60px] tdprb-aspect-square tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px] tdprb-cursor-pointer"
      v-for="(shape, index) in shapeNames" :key="index" :for="shape.replaceAll(' ', '-')">
      <input type="radio" v-model="selectedShape" :value="shape" :id="shape.replaceAll(' ', '-')" name="tdp_metal_names"
        hidden />
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
</template>

<script>

export default {
  props: {
    selectedMetal: {
      type: String,
      default: null,
    },
    metalNames: {
      type: Array,
    },
  },
  emits: ['update'],
  data() {
    return {
      shapeNames: [],
      selectedShape: null,
    };
  },
  methods: {
    getMetals(metal, isActive) {
      return this.$getMetals(metal, isActive)
    },
    separateNameAndCarat(fullname) {
      return this.$separateCaratAndName(fullname)
    },
  },
  watch: {
    metalNames: {
      immediate: true,
      handler(newNames) {
        if (newNames) {
          this.shapeNames = newNames
        }
      }
    },
    selectedMetal: {
      immediate: true,
      handler(newMetal) {
        if (newMetal) {
          this.selectedShape = newMetal
        }
      }
    },
    selectedShape: {
      immediate: true,
      handler(newShape) {
        if (newShape) {
          this.$emit('update', newShape)
        }
      }
    },
  }
};
</script>