<template>
    <div :class="isNormalLayout ? normalLayoutClasses : wideLayoutClasses">
        <label v-if="isLoading" v-for="(shape, index) in shapeNames" :key="shape" :class="labelClasses">
            <div :class="loadingShapeClasses"></div>
        </label>
        <label v-else v-for="(shape, index) in shapeNames" :key="index" :title="shape.toUpperCase()"
            :for="`ring-style-${shape}`" :class="labelClasses">
            <input type="radio" v-model="selectedShape" :value="shape" :id="`ring-style-${shape}`" hidden />
            <div :class="['shapeContainer', { 'selectedShape': shape === selectedShape }]">
                <div class="shapeContent" v-html="getRingStyles(shape, shape == selectedShape)"></div>
            </div>
            <div v-if="!isNormalLayout" class="labelText">
                <span class="labelSpan">{{ toSentenceCaseFunction(shape).replace('_', "-") }}</span>
            </div>
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
            selectedShape: '',
            shapeNames: [],
            isLoading: false,
            isNormalLayout: false
        };
    },
    computed: {
        getFilterData() {
            return this.$store.getters['settingFilters/getFilterData']('ring_style');
        },
        getFilterValue() {
            return this.$store.getters['settingFilters/getFilterValue']('ring_style');
        },
        getAllFilters() {
            return this.$store.getters['settingFilters/getAllFilters'];
        },
        toSentenceCaseFunction() {
            return this.$toSentenceCase;
        },
        layoutType() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('layout');
        },
        normalLayoutClasses() {
            return "tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-[10px] tdprb-flex-nowrap tdprb-overflow-x-auto tdprb-overflow-y-hidden tdprb-custom-scrollbar";
        },
        wideLayoutClasses() {
            return "tdprb-flex tdprb-justify-start tdprb-items-center md:tdprb-gap-[30px] tdprb-gap-[15px] tdprb-flex-wrap tdprb-overflow-x-hidden tdprb-gap-[18px] tdprb-max-h-[300px] tdprb-overflow-y-auto";
        },
        labelClasses() {
            return this.isNormalLayout ? "md:tdprb-w-[100px] tdprb-w-[75px] tdprb-min-h-[60px] tdprb-cursor-pointer tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px]" : "md:tdprb-w-[100px] tdprb-w-[75px] tdprb-min-h-[60px] tdprb-cursor-pointer tdprb-flex tdprb-flex-col tdprb-items-center tdprb-justify-between tdprb-gap-[5px]";
        },
        loadingShapeClasses() {
            return "tdprb-flex tdprb-justify-center tdprb-items-center tdprb-h-[50px] tdprb-w-full tdprb-object-cover tdprb-rounded-lg tdprb-shape tdprb-px-2 tdprb-skeleton-loader";
        }
    },
    created() {
        this.selectedShape = this.getFilterValue;
    },
    methods: {
        getRingStyles(style, isActive) {
            return this.$getRingStyles(style, isActive)
        },
        updateSettingFilters(filterData) {
            this.$store.dispatch('settingFilters/updateFilterValue', filterData);
        }
    },
    watch: {
        layoutType: {
            immediate: true,
            deep: true,
            handler(newVal) {
                this.isNormalLayout = newVal === 'normal';
            }
        },
        getFilterData: {
            immediate: true,
            deep: true,
            handler(newVal) {
                if (newVal?.length) {
                    this.shapeNames = newVal;
                }
            }
        },
        shapeNames: {
            immediate: true,
            deep: true,
            handler(newVal) {
                if (newVal.length) {
                    this.isLoading = false;
                }
            }
        },
        getFilterValue: {
            handler(newVal) {
                this.selectedShape = newVal;
            },
            immediate: true,
            deep: true
        },
        selectedShape: {
            handler(newVal) {
                if (newVal) {
                    this.updateSettingFilters({ filter: 'ring_style', value: newVal });
                }
            },
            immediate: true
        }
    }
};
</script>

<style scoped>
.shapeContainer {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60px;
    width: 100%;
    object-fit: contain;
    border-radius: 0.375rem;
    padding: 0.5rem;
}

.shapeContainer.selectedShape {
    background-color: var(--theme-color);
}

.shapeContent {
    object-fit: contain;
    transform: scale(0.75);
}

.labelText {
    height: 30%;
    width: 100%;
    text-align: center;
    text-wrap: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.labelSpan {
    font-size: 16px;
    font-weight: 400;
    line-height: 18px;
    font-family: 'Lato', sans-serif;
    color: var(--text2-color);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
