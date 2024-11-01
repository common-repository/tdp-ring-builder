<template>
    <!-- diamond type start -->
    <DiamondType />
    <!-- diamond type end -->


    <!-- normal layout start -->
    <div v-if="layoutType == 'normal'" class="tdprb-w-full tdprb-flex tdprb-flex-col ">
        <div v-if="diamondType == 'natural'" class="tdprb-grid tdprb-grid-cols-1 md:tdprb-grid-cols-2 md:tdprb-px-[30px] tdprb-px-[15px] ">
            <!-- Render all filters dynamically -->
            <div class="tdprb-w-full" v-if="filterData.length" v-for="(filter, index) in filterData" :key="'filter-' + index"
                :class="getNormalFilterClass(filter.key)">
                <div class="tdprb-h-full tdprb-w-[20%] ">
                    <!-- Label component -->
                    <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                </div>

                <div class="tdprb-h-full tdprb-w-[80%] tdprb-py-[5px] tdprb-px-[10px] tdprb-overflow-hidden">
                    <!-- Dynamic component selection -->
                    <component :is="getComponentName(filter.key)" :filterType="filter.key" />
                </div>

            </div>

            <!-- Render all advancedFilterData filters dynamically -->
            <div class="tdprb-w-full" v-if="isAdvancedFilter" v-for="(filter, index) in advancedFilterData" :key="'advanced-filter-' + index"
                :class="getNormalFilterClass(filter.key)">
                <div class="tdprb-h-full tdprb-w-[20%] ">
                    <!-- Label component -->
                    <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                </div>

                <div class="tdprb-h-full tdprb-w-[80%] tdprb-py-[5px] tdprb-px-[10px] tdprb-overflow-hidden">

                    <!-- Dynamic component selection -->
                    <component :is="getComponentName(filter.key)" :filterType="filter.key" />
                </div>
            </div>
        </div>
        <div v-else class="tdprb-grid tdprb-grid-cols-1 md:tdprb-grid-cols-2 md:tdprb-px-[30px] tdprb-px-[15px] ">

            <!-- Render all filters dynamically -->
            <div class="tdprb-w-full" v-if="filterData.length" v-for="(filter, index) in filterData" :key="'filter-' + index"
                :class="getNormalFilterClass(filter.key)">

                <div class="tdprb-h-full tdprb-w-[20%] ">
                    <!-- Label component -->
                    <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                </div>
                <div class="tdprb-h-full tdprb-w-[80%] tdprb-py-[5px] tdprb-px-[10px] tdprb-overflow-hidden">
                    <!-- Dynamic component selection -->
                    <component :is="getComponentName(filter.key)" :filterType="filter.key" />
                </div>
            </div>

            <!-- Render all advancedFilterData filters dynamically -->
            <div class="tdprb-w-full" v-if="isAdvancedFilter" v-for="(filter, index) in advancedFilterData" :key="'advanced-filter-' + index"
                :class="getNormalFilterClass(filter.key)">

                <div class="tdprb-h-full tdprb-w-[20%] ">
                    <!-- Label component -->
                    <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                </div>
                <div class="tdprb-h-full tdprb-w-[80%] tdprb-py-[5px] tdprb-px-[10px] tdprb-overflow-hidden">
                    <!-- Dynamic component selection -->
                    <component :is="getComponentName(filter.key)" :filterType="filter.key" />
                </div>
            </div>
        </div>

        <template v-if="advancedFilterData.length">
            <!-- Advanced Filter Button -->
            <div
                class="tdprb-mt-[60px] tdprb-flex  tdprb-justify-center tdprb-items-center tdprb-relative tdprb-w-full tdprb-h-[1px] tdprb-bg-borderColor">
                <button @click="toggleAdvancedFilter"
                    class="tdprb-w-[230px] tdprb-h-[54px] tdprb-rounded tdprb-bg-themeColor tdprb-text-backgroundColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-font-lato tdprb-font-[500] tdprb-text-[16px] tdprb-leading-[20px] tdprb-cursor-pointer">
                    Advanced Option
                </button>
            </div>

            <!-- Reset filters button -->
            <div class="tdprb-mt-[40px] tdprb-flex tdprb-justify-center tdprb-items-center tdprb-w-full">
                <button @click="clearFilters" :disabled="this.isReset"
                    class="tdprb-text-themeColor tdprb-bg-backgroundColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor  tdprb-font-lato  tdprb-font-[500]  hover:tdprb-underline tdprb-underline-offset-2 tdprb-text-[16px] tdprb-leading-[20px] tdprb-cursor-pointer tdprb-transition-all tdprb-duration-300 tdprb-ease-in-out tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-2"
                    :class="isReset && 'tdprb-cursor-wait'">
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
        </template>
        <!-- Reset filters button -->
        <div v-else
            class="tdprb-mt-[40px] tdprb-flex tdprb-justify-center tdprb-items-center tdprb-w-full md:tdprb-px-[30px] tdprb-px-[15px]">
            <button @click="clearFilters" :disabled="isReset"
                class="tdprb-text-themeColor tdprb-bg-backgroundColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor  tdprb-font-lato  tdprb-font-[500]  hover:tdprb-underline tdprb-underline-offset-2 tdprb-text-[17px]  tdprb-cursor-pointer tdprb-transition-all tdprb-duration-300 tdprb-ease-in-out tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-2"
                :class="isReset && 'tdprb-cursor-wait'">
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
        <DiamondViewControls />
    </div>
    <!-- normal layout end -->
     
    <!-- boxy layout start  -->
    <div v-else class="tdprb-w-full tdprb-flex tdprb-flex-col">
        <div v-if="diamondType == 'natural'"
            class="tdprb-grid tdprb-grid-cols-1 md:tdprb-grid-cols-2 tdprb-gap-y-[20px] tdprb-gap-x-[30px] md:tdprb-px-[30px] tdprb-px-[15px]">
            <!-- Render all filters dynamically -->
            <div class="tdprb-w-full" v-if="filterData.length" v-for="(filter, index) in filterData" :key="'filter-' + index"
                :class="getBoxyFilterClass(filter.key)">
                <!-- Label component -->
                <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                <!-- Dynamic component selection -->
                <component :is="getComponentName(filter.key)" :filterType="filter.key" />
            </div>

            <!-- Render all advancedFilterData filters dynamically -->
            <div class="tdprb-w-full" v-if="isAdvancedFilter" v-for="(filter, index) in advancedFilterData" :key="'advanced-filter-' + index"
                :class="getBoxyFilterClass(filter.key)">
                <!-- Label component -->
                <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                <!-- Dynamic component selection -->
                <component :is="getComponentName(filter.key)" :filterType="filter.key" />
            </div>
        </div>

        <div v-else class="tdprb-grid tdprb-grid-cols-1 md:tdprb-grid-cols-2 tdprb-gap-y-[20px] tdprb-gap-x-[30px] md:tdprb-px-[30px] tdprb-px-[15px]">
            <!-- Render all filters dynamically -->
            <div class="tdprb-w-full" v-if="filterData.length" v-for="(filter, index) in filterData" :key="'filter-' + index"
                :class="getBoxyFilterClass(filter.key)">
                <!-- Label component -->
                <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                <!-- Dynamic component selection -->
                <component :is="getComponentName(filter.key)" :filterType="filter.key" />
            </div>

            <!-- Render all advancedFilterData filters dynamically -->
            <div class="tdprb-w-full" v-if="isAdvancedFilter" v-for="(filter, index) in advancedFilterData" :key="'advanced-filter-' + index"
                :class="getBoxyFilterClass(filter.key)">
                <!-- Label component -->
                <LabelComp :title="filter.text" :description="setDescription(filter.text)" />
                <!-- Dynamic component selection -->
                <component :is="getComponentName(filter.key)" :filterType="filter.key" />
            </div>
        </div>

        <template v-if="advancedFilterData.length">
            <!-- Advanced Filter Button -->
            <div
                class="tdprb-mt-[60px] tdprb-flex  tdprb-justify-center tdprb-items-center tdprb-relative tdprb-w-full tdprb-h-[1px] tdprb-bg-borderColor">
                <button @click="toggleAdvancedFilter"
                    class="tdprb-w-[230px] tdprb-h-[54px] tdprb-rounded tdprb-bg-themeColor tdprb-text-backgroundColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-font-lato tdprb-font-[500] tdprb-text-[16px] tdprb-leading-[20px] tdprb-cursor-pointer">
                    Advanced Option
                </button>
            </div>

            <!-- Reset filters button -->
            <div class="tdprb-mt-[40px] tdprb-flex tdprb-justify-center tdprb-items-center tdprb-w-full">
                <button @click="clearFilters" :disabled="isReset"
                    class="tdprb-text-themeColor tdprb-bg-backgroundColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor tdprb-font-lato  tdprb-font-[500]  hover:tdprb-underline tdprb-underline-offset-2 tdprb-text-[16px] tdprb-leading-[20px] tdprb-cursor-pointer tdprb-transition-all tdprb-duration-300 tdprb-ease-in-out tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-2"
                    :class="isReset && 'tdprb-cursor-wait'">
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
        </template>

        <!-- Reset filters button -->
        <div v-else
            class="tdprb-mt-[40px] tdprb-flex tdprb-justify-center tdprb-items-center tdprb-w-full md:tdprb-px-[30px] tdprb-px-[15px]">
            <button @click="clearFilters" :disabled="isReset"
                class="tdprb-text-themeColor tdprb-bg-backgroundColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor  tdprb-font-lato  tdprb-font-[500]  hover:tdprb-underline tdprb-underline-offset-2 tdprb-text-[17px]  tdprb-cursor-pointer tdprb-transition-all tdprb-duration-300 tdprb-ease-in-out tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-2"
                :class="isReset && 'tdprb-cursor-wait'">
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
        <DiamondViewControls />
    </div>
    <!-- boxy layout end  -->


</template>

<script>


export default {
    data() {
        return {
            filterData: [],
            advancedFilterData: [],
            isAdvancedFilter: false,
            isReset: false,
        };
    },
    computed: {
        loading() {
            return this.$store.getters['diamondListApi/loading']
        },
        diamondType() {
            return this.$store.getters['diamondFilters/getFilterValue']('diamond_type');
        },
        layoutType() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('layout');
        },
        filters() {
            return this.$store.getters['diamondSettings/filters'];
        },
        AdvancedFilters() {
            return this.$store.getters['diamondSettings/AdvancedFilters'];
        },
        getIsAdvancedFilter() {
            return this.$store.getters['diamondSettings/getIsAdvancedFilter'];
        },
    },
    methods: {
        setDescription(title) {
            return this.$getDiamondTooltipText(title)
        },
        clearFilters() {
            if (!this.isReset) {
                this.isReset = true;
                this.$store.dispatch('diamondFilters/resetFilters');
            }
        },
        getComponentName(key) {
            // Map filter keys to component names
            const componentMap = {
                shape: 'Shape',
                cut: 'Slider',
                lab: 'Slider',
                clarity: 'Slider',
                carats: 'Slider',
                price: 'Slider',
                color: 'Slider',
                polish: 'Slider',
                symmetry: 'Slider',
                fluorescence: 'Slider',
                depth_pr: 'Slider',
                table_pr: 'Slider',
                l_w_ratio: 'Slider',
                fancy_color: 'FancyColor'
            };
            return componentMap[key] || 'div'; // Default to div if no match
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
                key === 'shape' ? 'md:tdprb-col-span-2 tdprb-col-span-1' : ''
            ];
        },
        getNormalFilterClass(key) {
            return [
                'tdprb-py-[10px] md:tdprb-py-[20px]',
                'tdprb-px-[0px] md:tdprb-px-[20px]',
                'tdprb-flex',
                'tdprb-justify-between',
                'tdprb-items-start',
                'md:tdprb-gap-0 tdprb-gap-[30px]',
            ];
        },
        toggleAdvancedFilter() {
            this.isAdvancedFilter = !this.isAdvancedFilter;
        }
    },
    watch: {
        getIsAdvancedFilter: {
            handler(newVal) {
                if (!!newVal) {
                    this.isAdvancedFilter = newVal;
                }
            },
            immediate: true,
            deep: true
        },
        AdvancedFilters: {
            handler(newVal) {
                if (!!newVal) {
                    this.advancedFilterData = newVal;
                }
            },
            immediate: true,
            deep: true
        },
        filters: {
            handler(newVal) {
                if (!!newVal) {
                    this.filterData = newVal;
                }
            },
            immediate: true,
            deep: true
        },
        loading: {
            handler(newVal) {
                if (!newVal) {
                    this.isReset = false;
                }
            },
            immediate: true,
            deep: true
        }
    }
};
</script>