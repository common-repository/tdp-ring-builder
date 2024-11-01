<template>
    <div class="tdprb-w-full tdprb-flex tdprb-flex-col md:tdprb-gap-[20px] tdprb-gap-[5x]">
        <template v-if="filterData.length">

            <!-- setting title  -->
            <div class="tdprb-w-full tdprb-mt-[20px] tdprb-mb-[10px] md:tdprb-mt-[40px] md:tdprb-mb-[10px] md:tdprb-px-[30px] tdprb-px-[15px]">
                <p
                    class="tdprb-font-lato tdprb-font-[500] tdprb-text-[16px] tdprb-leading-[20px] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-text-textSecondaryColor">
                    Create Engagement Ring</p>
            </div>
            <!-- setting title  -->

            <div v-if="isNormalLayout" class="tdprb-grid md:tdprb-grid-cols-2 tdprb-grid-cols-1 md:tdprb-px-[30px] tdprb-px-[15px]">
                <!-- Render all filters dynamically -->
                <div class="tdprb-w-full" v-for="(filter, index) in filterData" :key="'filter-' + index"
                    :class="getNormalFilterClass(filter.key)">

                    <div class="tdprb-h-full tdprb-w-[20%]">
                        <!-- Label component -->
                        <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                    </div>
                    <div class="tdprb-h-full tdprb-w-[80%] tdprb-px-[10px] tdprb-py-[5px]  tdprb-overflow-hidden">
                        <!-- Dynamic component selection -->
                        <component :is="getComponentName(filter.key)" :filterType="filter.key" />
                    </div>

                </div>
            </div>
            <div v-else class="tdprb-grid md:tdprb-grid-cols-2 tdprb-grid-cols-1 tdprb-gap-y-[20px] tdprb-gap-x-[30px] md:tdprb-px-[30px] tdprb-px-[15px]">
                <!-- Render all filters dynamically -->
                <div class="tdprb-w-full" v-for="(filter, index) in filterData" :key="'filter-' + index"
                    :class="getBoxyFilterClass(filter.key)">
                    <!-- Label component -->
                    <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                    <!-- Dynamic component selection -->
                    <component :is="getComponentName(filter.key)" :filterType="filter.key" />
                </div>
            </div>

        </template>

        <!-- Reset filters button -->
        <div class=" tdprb-flex tdprb-justify-center tdprb-items-center tdprb-w-full md:tdprb-px-[30p tdprb-px1530px] tdprb-mt-[20px]">
            <button @click="clearFilters"
                class="tdprb-text-themeColor tdprb-font-lato  tdprb-font-[500]  hover:tdprb-underline tdprb-underline-offset-2 tdprb-text-[17px]  tdprb-cursor-pointer tdprb-transition-all tdprb-duration-300 tdprb-ease-in-out tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-2">
                <span :class="isReset && 'tdprb-animate-spin'"
                    class="tdprb-h-full tdprb-flex tdprb-justify-center tdprb-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                        <path
                            d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9" />
                        <path fill-rule="evenodd"
                            d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z" />
                    </svg>
                </span>
                <span class="tdprb-h-full tdprb-flex tdprb-justify-center tdprb-items-center">Reset Filters</span>
            </button>
        </div>

        <!-- View Controls Component -->
        <SettingViewControls />
    </div>
</template>

<script>


export default {
    data() {
        return {
            filterData: [],
            isNormalLayout: false,
            isReset: false,

        };
    },
    computed: {
        filters() {
            return this.$store.getters['settingSettings/filters'];
        },
        layoutType() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('layout');
        },
        loading() {
            return this.$store.getters['settingListApi/loading']
        },
    },
    methods: {
        setDescription(title) {
            return this.$getSettingTooltipText(title)
        },
        clearFilters() {
            if (!this.loading) {
                this.isReset = true;
                this.$store.dispatch('settingFilters/resetFilters');
            }
        },
        getComponentName(key) {
            // Map filter keys to component names
            const componentMap = {
                ring_style: 'RingStyle',
                shape: 'Shape',
                price: 'Slider',
                metal: 'Metal'
            };
            return componentMap[key] || 'div'; // Default to div if no match
        },
        getNormalFilterClass(key) {
            return [
                'tdprb-py-[10px] md:tdprb-py-[20px]',
                'tdprb-px-[0px] md:tdprb-px-[20px]',
                'tdprb-rounded-md',
                'tdprb-flex',
                'tdprb-justify-start',
                'tdprb-gap-[20px]',
                // key === 'shape' || key === 'ring_style' ? 'tdprb-col-span-2' : ''
            ];
        },
        getBoxyFilterClass(key) {
            return [
                'tdprb-py-[20px]',
                'md:tdprb-px-[30px] tdprb-px-[15px]',
                'tdprb-min-h-[120px]',
                'tdprb-border',
                'tdprb-border-borderColor',
                'tdprb-rounded-md',
                'tdprb-flex',
                'tdprb-flex-col',
                'tdprb-justify-start',
                'tdprb-gap-[20px]',
                key === 'shape' || key === 'ring_style' ? 'md:tdprb-col-span-2 tdprb-col-span-1' : ''
            ];
        },
    },
    watch: {
        loading: {
            immediate: true,
            handler(newVal) {
                if (!newVal) {
                    this.isReset = false;
                }
            }
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
        filters: {
            handler(newVal) {
                this.filterData = newVal;
            },
            immediate: true,
            deep: true
        }
    }
};
</script>