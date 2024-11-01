<template lang="">
    <!-- product view control  -->
    <div class='tdprb-w-full tdprb-h-full tdprb-flex tdprb-flex-col md:tdprb-flex-row tdprb-gap-[20px] tdprb-justify-between tdprb-items-center md:tdprb-px-[30px] tdprb-px-[15px] md:tdprb-py-10 tdprb-py-5  tdprb-border-b tdprb-border-borderColor'>
        <div class='tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-center tdprb-items-start tdprb-flex-col tdprb-gap-2'>
           <span class="tdprb-font-lato tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[20px] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-text-themeColor">{{title}}</span>
           <span v-if="dataCount && !loading && !dataNotFound" class="tdprb-font-lato tdprb-text-[12px] tdprb-font-[400] tdprb-leading-[12.8px] md:tdprb-text-[14px] md:tdprb-leading-[16.8px]  tdprb-text-textSecondaryColor">{{`${dataCount} Engagement Ring Settings`}}</span>
           <span v-else class="tdprb-font-lato tdprb-text-[12px] tdprb-font-[400] tdprb-leading-[12.8px] md:tdprb-text-[14px] md:tdprb-leading-[16.8px] tdprb-text-textSecondaryColor">{{`Can't find what you're looking for?`}}</span>
        </div>
        <div class='tdprb-w-full tdprb-h-full tdprb-flex md:tdprb-justify-end tdprb-justify-start tdprb-items-center tdprb-gap-3'>
            <div ref="tdprbSortByDropdown"  @click='isDropDownOpen = !isDropDownOpen' class='tdprb-w-[230px] tdprb-h-[50px]  tdprb-flex tdprb-justify-center tdprb-items-center tdprb-p-1 tdprb-border tdprb-border-themeColor tdprb-rounded tdprb-cursor-pointer tdprb-relative'>
                <div  class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-6">
                    <span class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-poppins tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[24px] tdprb-text-themeColor tdprb-select-none">Sort: {{sortByOptions[sortByValue]}}</span>
                    <span class="tdprb-flex tdprb-justify-center tdprb-items-center">
                        <svg :class="isDropDownOpen && 'tdprb-rotate-180'" width="12" height="6" viewBox="0 0 12 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 6L-2.33649e-06 -1.04907e-06L12 0L6 6Z" :fill="prussianBlue()"/>
                        </svg>                            
                    </span>
                </div>
                <div v-if="isDropDownOpen"  class="tdprb-absolute tdprb-top-14 tdprb-bg-backgroundColor tdprb-w-full tdprb-flex tdprb-justify-center tdprb-items-center tdprb-flex-col tdprb-gap-1 tdprb-p-2 tdprb-border tdprb-border-borderColor  tdprb-rounded-md tdprb-shadow-xl tdprb-z-20" >
                    <template v-for="(value, key, index) in sortByOptions" :key="index">
                        <label @click="dropdownHandle(key)" class="tdprb-w-full tdprb-h-[40px] tdprb-px-2 hover:tdprb-shadow-md hover:tdprb-rounded-md tdprb-cursor-pointer tdprb-flex tdprb-justify-start tdprb-items-center tdprb-border-b tdprb-border-borderColor " :class="sortByValue == key ? 'tdprb-shadow tdprb-rounded tdprb-border tdprb-border-borderColor tdprb-bg-themeColor tdprb-text-backgroundColor' : 'hover:tdprb-shadow hover:tdprb-rounded tdprb-bg-backgroundColor tdprb-text-themeColor'">
                            <span class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-poppins tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[16px]">{{value}}</span>
                        </label>
                    </template>
</div>
</div>
<div
    class='tdprb-w-[95px] tdprb-h-[50px]  tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-1 tdprb-p-1 tdprb-border tdprb-border-themeColor tdprb-rounded tdprb-bg-backgroundColor'>
    <button @click="changeViewMode('grid')"
        class=" tdprb-h-full tdprb-w-full tdprb-flex tdprb-justify-center tdprb-items-center tdprb-rounded-sm"
        :class="productViewMode == 'grid' ? 'tdprb-bg-themeColor hover:tdprb-bg-themeColor' : 'tdprb-bg-backgroundColor hover:tdprb-bg-backgroundColor'">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M5 0H1C0.447266 0 0 0.447266 0 1V5C0 5.55273 0.447266 6 1 6H5C5.55273 6 6 5.55273 6 5V1C6 0.447266 5.55273 0 5 0Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
            <path
                d="M12 0H8C7.44727 0 7 0.447266 7 1V5C7 5.55273 7.44727 6 8 6H12C12.5527 6 13 5.55273 13 5V1C13 0.447266 12.5527 0 12 0Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
            <path
                d="M19 0H15C14.4473 0 14 0.447266 14 1V5C14 5.55273 14.4473 6 15 6H19C19.5527 6 20 5.55273 20 5V1C20 0.447266 19.5527 0 19 0Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
            <path
                d="M5 14H1C0.447266 14 0 14.4473 0 15V19C0 19.5527 0.447266 20 1 20H5C5.55273 20 6 19.5527 6 19V15C6 14.4473 5.55273 14 5 14Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
            <path
                d="M12 14H8C7.44727 14 7 14.4473 7 15V19C7 19.5527 7.44727 20 8 20H12C12.5527 20 13 19.5527 13 19V15C13 14.4473 12.5527 14 12 14Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
            <path
                d="M19 14H15C14.4473 14 14 14.4473 14 15V19C14 19.5527 14.4473 20 15 20H19C19.5527 20 20 19.5527 20 19V15C20 14.4473 19.5527 14 19 14Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
            <path
                d="M5 7H1C0.447266 7 0 7.44727 0 8V12C0 12.5527 0.447266 13 1 13H5C5.55273 13 6 12.5527 6 12V8C6 7.44727 5.55273 7 5 7Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
            <path
                d="M12 7H8C7.44727 7 7 7.44727 7 8V12C7 12.5527 7.44727 13 8 13H12C12.5527 13 13 12.5527 13 12V8C13 7.44727 12.5527 7 12 7Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
            <path
                d="M19 7H15C14.4473 7 14 7.44727 14 8V12C14 12.5527 14.4473 13 15 13H19C19.5527 13 20 12.5527 20 12V8C20 7.44727 19.5527 7 19 7Z"
                :fill="productViewMode == 'grid' ? white() : prussianBlue()" />
        </svg>
    </button>
    <button @click="changeViewMode('list')"
        class=" tdprb-h-full tdprb-w-full tdprb-flex tdprb-justify-center tdprb-items-center tdprb-rounded-sm"
        :class="productViewMode == 'list' ? 'tdprb-bg-themeColor hover:tdprb-bg-themeColor' : 'tdprb-bg-backgroundColor hover:tdprb-bg-backgroundColor'">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M19.1667 20H7.5C7 20 6.66667 19.6364 6.66667 19.0909V15.4545C6.66667 14.9091 7 14.5455 7.5 14.5455H19.1667C19.6667 14.5455 20 14.9091 20 15.4545V19.0909C20 19.6364 19.6667 20 19.1667 20ZM4.16667 20H0.833333C0.333333 20 0 19.6364 0 19.0909V15.4545C0 14.9091 0.333333 14.5455 0.833333 14.5455H4.16667C4.66667 14.5455 5 14.9091 5 15.4545V19.0909C5 19.6364 4.66667 20 4.16667 20ZM19.1667 12.7273H7.5C7 12.7273 6.66667 12.3636 6.66667 11.8182V8.18182C6.66667 7.63636 7 7.27273 7.5 7.27273H19.1667C19.6667 7.27273 20 7.63636 20 8.18182V11.8182C20 12.3636 19.6667 12.7273 19.1667 12.7273ZM4.16667 12.7273H0.833333C0.333333 12.7273 0 12.3636 0 11.8182V8.18182C0 7.63636 0.333333 7.27273 0.833333 7.27273H4.16667C4.66667 7.27273 5 7.63636 5 8.18182V11.8182C5 12.3636 4.66667 12.7273 4.16667 12.7273ZM19.1667 5.45455H7.5C7 5.45455 6.66667 5.09091 6.66667 4.54545V0.909091C6.66667 0.363636 7 0 7.5 0H19.1667C19.6667 0 20 0.363636 20 0.909091V4.54545C20 5.09091 19.6667 5.45455 19.1667 5.45455ZM4.16667 5.45455H0.833333C0.333333 5.45455 0 5.09091 0 4.54545V0.909091C0 0.363636 0.333333 0 0.833333 0H4.16667C4.66667 0 5 0.363636 5 0.909091V4.54545C5 5.09091 4.66667 5.45455 4.16667 5.45455Z"
                :fill="productViewMode == 'list' ? white() : prussianBlue()" />
        </svg>
    </button>
</div>
</div>
</div>
<!-- product view controls -->

<!-- product view modes  -->
<div class='tdprb-w-full tdprb-h-full'>
    <Loader v-if="loading" containerClass="tdprb-h-[50vh]" />
    <Error v-else-if="dataNotFound" :message="dataNotFoundMsg" containerClass="tdprb-h-[50vh]" />
    <template v-else>
        <template v-if="data.length">
            <SettingGridView v-show="productViewMode == 'grid'" :products="data" />
            <SettingListView v-show="productViewMode == 'list'" :products="data" />
            
            <!-- scroll to load more component  -->
            <div v-if="!lastPage" ref="loadMoreComp" class="tdprb-w-full" >
                <Loader v-if="loadMoreLoading" containerClass="tdprb-h-[200px]" />
                <div v-else  class="tdprb-w-full tdprb-h-[200px] tdprb-flex tdprb-justify-center tdprb-items-center" @click="callProductListApi('overload')">
                    <div class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-flex-col tdprb-gap-5">
                        <span class="tdprb-font-[600] tdprb-text-[22px] tdprb-text-themeColor">Scroll To Load More</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" :fill="prussianBlue()"
                            class="bi bi-chevron-double-down tdprb-animate-bounce" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                            <path fill-rule="evenodd"
                                d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg>
                    </div>
                </div>
            </div>
        </template>
    </template>
</div>
<!-- product view modes  -->

</template>
<script>


export default {
    data() {
        return {
            title: "Ring Settings",
            productViewMode: 'grid', // grid | list
            sortByValue: null,
            isDropDownOpen: false,
            sortByOptions: {
                1: 'Best Value',
                2: 'Price: Low to High',
                3: 'Price: High to Low',
            },
            allFilters: {},
            options: {
                root: null,
                threshold: 0, // Directly using number instead of string
            },
            observer: null,
        }
    },

    computed: {
        data() {
            return this.$store.getters['settingListApi/data']
        },
        dataCount() {
            return this.$store.getters['settingListApi/dataCount']
        },
        currentPage() {
            return this.$store.getters['settingListApi/currentPage']
        },
        lastPage() {
            return this.$store.getters['settingListApi/lastPage']
        },
        dataNotFound() {
            return this.$store.getters['settingListApi/dataNotFound']
        },
        dataNotFoundMsg() {
            return this.$store.getters['settingListApi/dataNotFoundMsg']
        },
        sortField() {
            return this.$store.getters['settingFilters/getFilterValue']('sort_field');
        },
        loading() {
            return this.$store.getters['settingListApi/loading']
        },
        loadMoreLoading() {
            return this.$store.getters['settingListApi/loadMoreLoading']
        },
        getAllFilters() {
            return this.$store.getters['settingFilters/getAllFilters'];
        },
    },
    mounted() {
        document.addEventListener('scroll', this.setObserver);
        document.addEventListener('click', this.handleClickOutside);
        this.sortByValue = this.sortField;
    },
    methods: {
        prussianBlue() {
            return this.$colors().prussianBlue;
        },
        white() {
            return this.$colors().white;
        },
        dropdownHandle(value) {
            if (this.sortByValue == value) {
                this.sortByValue = 1
            } else {
                this.sortByValue = value
            }
        },
        setObserver() {
            if (this.$refs.loadMoreComp) {
                this.observer = new IntersectionObserver(this.handleIntersect, this.options);
                this.observer.observe(this.$refs.loadMoreComp);
            }
        },
        handleIntersect([entry]) { // Using array destructuring for cleaner code
            if (entry.isIntersecting && !this.loadMoreLoading && !this.loading && this.data.length) {
                this.callProductListApi('overload')
            }
        },
        callProductListApi(type = 'override') {
            this.$store.dispatch('settingListApi/fetchSettingList', {
                filters: this.getAllFilters || {},
                type: type, // or 'append' based on your requirement
            });
        },
        handleClickOutside(event) {
            if (this.$refs.tdprbSortByDropdown && !this.$refs.tdprbSortByDropdown.contains(event.target)) {
                this.isDropDownOpen = false;
            }
        },
        changeViewMode(viewMode) {
            this.productViewMode = viewMode;
        },
        updateFilter(filter, value) {
            this.$store.dispatch('settingFilters/updateFilterValue', { filter, value });
        },
    },
    watch: {
        sortField: {
            handler(newValue) {
                this.sortByValue = newValue;
            },
            deep: true,
            immediate: true
        },
        sortByValue: {
            handler(newValue) {
                if (!!newValue) {
                    this.updateFilter('sort_field', newValue);
                }
            },
            deep: true,
            immediate: true
        },
        getAllFilters: {
            handler(newValue) {
                if (!!newValue) {
                    this.callProductListApi();
                }
            },
            immediate: true,
            deep: true
        },
        getDefaultViewMode: {
            handler(newValue) {
                if (!!newValue) {
                    this.productViewMode = newValue;
                }
            },
            immediate: true
        },
    },
    beforeDestroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
        document.removeEventListener('click', this.handleClickOutside);
        document.removeEventListener('scroll', this.setObserver);
    },
}
</script>
<style lang="">

</style>