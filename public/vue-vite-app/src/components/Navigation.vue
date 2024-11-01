<template>
    <div class="tdprb-h-full tdprb-w-full md:tdprb-px-[30px]">
        <div
            class="tdprb-font-lato tdprb-font-[500] tdprb-text-[16px] tdprb-text-themeColor tdprb-mb-[20px] md:tdprb-px-[0px] tdprb-px-[15px]">
            Ring Builder
        </div>
        <nav
            class="tdprb-h-auto tdprb-rounded-sm tdprb-w-full tdprb-border tdprb-border-borderColor tdprb-overflow-hidden tdprb-cursor-pointer tdprb-grid tdprb-grid-cols-3  ">
            <template v-for="(tab, index) in tabs" :key="index">
                <label
                    class="md:tdprb-h-[100px] tdprb-h-[60px]  tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center"
                    :class="{
                        'tdprb-nav-center-side': index === 1, // Applies this class if the index is 1
                        'tdprb-nav-left-side': index === 0, // Applies this class if the index is 0
                        'tdprb-active-nav-tab-bg-before-after': tab.relativeSlugs.includes(activeNavTab), // Applies this class if the activeNavTab is included in relativeSlugs
                        'tdprb-cursor-pointer': (tab.to !== 'CompleteRingPage' && isEmptyObject(tab.selectedData)) || (tab.to === 'CompleteRingPage' && isProductCompleted()), // Applies this class if tab.selectedData is empty
                        'tdprb-cursor-not-allowed': (tab.to === 'CompleteRingPage' && !isProductCompleted()) // Applies this class if tab.to is 'CompleteRingPage' and the product is not completed
                    }" @click="changePage(tab)">
                    <div
                        class=" md:tdprb-max-w-[350px] lg:tdprb-max-w-[400px] xl:tdprb-max-w-[450px] tdprb-w-full tdprb-h-100 tdprb-flex tdprb-align-center tdprb-m-auto tdprb-gap-[20px]">
                        <div
                            class="tdprb-flex tdprb-items-center tdprb-justify-center tdprb-gap-[5px] md:tdprb-gap-[30px] tdprb-w-full md:tdprb-w-[60%]">
                            <div class="tdprb-nav-icon tdprb-flex tdprb-items-center tdprb-justify-center"
                                v-html="setSvgIcon(tab.to, tab.relativeSlugs.includes(activeNavTab))"
                                aria-hidden="true"></div>
                            <div class="tdprb-flex tdprb-items-start tdprb-justify-center tdprb-flex-col"
                                :class="tab.relativeSlugs.includes(activeNavTab) ? 'tdprb-text-backgroundColor' : 'tdprb-text-themeColor'"
                                :id="`tabLabel${index}`">
                                <div
                                    class="tdprb-font-lato tdprb-font-[500] tdprb-text-[14px] tdprb-leading-[20px] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-select-none">
                                    {{
                                        tab.label }}</div>
                                <div
                                    class="tdprb-font-lato tdprb-font-[400] tdprb-text-[14px] tdprb-leading-[16px] tdprb-select-none tdprb-hidden md:tdprb-block">
                                    {{
                                        tab.subTitle }}</div>
                            </div>
                        </div>
                        <div v-if="!isEmptyObject(tab.selectedData)"
                            class="tdprb-hidden md:tdprb-flex tdprb-nav-controls "
                            :class="tab.relativeSlugs.includes(activeNavTab) ? 'tdprb-text-backgroundColor' : 'tdprb-text-themeColor'">
                            <div
                                class="tdprb-font-lato tdprb-font-[500] tdprb-text-[22px] tdprb-leading-[30px] tdprb-select-none">
                                {{
                                    tab.label == 'Setting' ? roundOffPrice(tab.selectedData.total_price) :
                                        roundOffPrice(tab.selectedData.price) }}
                            </div>
                            <div v-if="tab.to != 'CompleteRingPage'"
                                class="tdprb-font-lato tdprb-font-[400] tdprb-text-[14px] tdprb-leading-[16px] tdprb-flex tdprb-items-center tdprb-gap-[10px] tdprb-text-center tdprb-select-none">
                                <span class="tdprb-cursor-pointer"
                                    @click.prevent="getDetailPage(tab.selectedData)">View</span> | <span
                                    class="tdprb-cursor-pointer" @click.prevent="removeItem(tab.label)">Remove</span>
                            </div>
                        </div>
                    </div>
                </label>
            </template>
        </nav>
    </div>
</template>


<script>
export default {
    data() {
        return {
            activeNavTab: this.getActiveNavTab || null,
            tabs: [
                {
                    label: "Diamond",
                    subTitle: "Choose Your Diamond",
                    to: "DiamondListPage",
                    relativeSlugs: ['DiamondListPage', 'DiamondDetailPage'],
                    selectedData: {},
                },
                {
                    label: "Settings",
                    subTitle: "Choose Your Settings",
                    to: "SettingListPage",
                    relativeSlugs: ['SettingListPage', 'SettingDetailPage'],
                    selectedData: {},
                },
                {
                    label: "Complete ring",
                    subTitle: "Preview Your Ring",
                    to: "CompleteRingPage",
                    relativeSlugs: ['CompleteRingPage'],
                    selectedData: {},
                },
            ],
        }
    },
    computed: {
        getProductsData() {
            return this.$store.getters['completeRing/getProductsData'];
        },
        headerText() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('header_texts');
        },
        getActiveNavTab() {
            return this.$store.getters['utility/getData']('activeNavTab');
        }
    },
    methods: {
        setSvgIcon(type, isActive) {
            return this.$getNavigationBarIcon(type, isActive)
        },
        roundOffPrice(price) {
            return this.$roundToTwoDecimals(price)
        },
        increasedPrice(price) {
            return this.$increasePriceByPercentage(price, 20)
        },
        reorderTabs(activeTab) {

            // Check if both diamond and setting data are empty
            const diamondDataEmpty = Object.keys(this.tabs[0].selectedData).length === 0;
            const settingDataEmpty = Object.keys(this.tabs[1].selectedData).length === 0;

            const currentIndex = this.tabs.findIndex(tab => tab.relativeSlugs.includes(activeTab));

            // When user clicks on 'DiamondListPage' and diamond data is empty
            if ((activeTab === "DiamondListPage" || activeTab === "DiamondDetailPage") && diamondDataEmpty && settingDataEmpty && currentIndex) {
                // Swap Diamond and DiamondListPage tabs
                [this.tabs[0], this.tabs[1]] = [this.tabs[1], this.tabs[0]];
            }
            // When user clicks on 'SettingListPage' and setting data is empty
            else if ((activeTab === "SettingListPage" || activeTab === "SettingDetailPage") && settingDataEmpty && diamondDataEmpty && currentIndex) {
                // Swap Diamond and Settings tabs back to original positions
                [this.tabs[0], this.tabs[1]] = [this.tabs[1], this.tabs[0]];
            }
        },
        removeItem(label) {
            if (label == 'Setting') {
                this.$store.dispatch('completeRing/removeSettingData');
            } else if (label == 'Diamond') {
                this.$store.dispatch('completeRing/removeDiamondData');
            }
        },
        isProductCompleted() {
            return !this.isEmptyObject(this.getProductsData.diamond) && !this.isEmptyObject(this.getProductsData.setting)
        },
        changePage(tab) {
            if (!!tab.to) {
                if ((!this.isEmptyObject(tab.selectedData) && tab.to != 'CompleteRingPage')) {
                    this.getDetailPage(tab.selectedData)
                } else {
                    if (tab.to == 'CompleteRingPage') {
                        if (this.isProductCompleted()) {
                            this.$router.push({ name: tab.to })
                        }
                    } else {
                        this.$router.push({ name: tab.to })
                    }
                }
            }
        },
        diamondType(product) {
            return product?.diamond_type === 'w' || product?.diamond_type === 'W' ? 'natural' : 'labgrown'
        },
        isEmptyObject(obj) {
            return Object.keys(obj).length === 0 && obj.constructor === Object;
        },
        getDetailPage(product) {
            this.$router.push({
                name: product.toName,
                params: {
                    id: product.sku,
                    type: this.diamondType(product)
                }
            })
        },
        setDataToUtility(type, data) {
            this.$store.dispatch('utility/setData', { key: type, value: data });
        }


    },
    watch: {
        activeNavTab: {
            immediate: true,
            deep: true,
            handler(val) {
                if (val) {
                    this.setDataToUtility('activeNavTab', val)
                }
            },
        },
        '$route': {
            handler(to, from) {
                if (!!to.name) {
                    this.activeNavTab = to.name;
                    this.reorderTabs(to.name);
                }
            },
            immediate: true,
            deep: true
        },
        headerText: {
            immediate: true,
            handler(val) {
                if (!this.isEmptyObject(val)) {
                    this.tabs.forEach(tab => {
                        if (tab.to === "DiamondListPage") {
                            tab.label = val.diamond.primary;
                            tab.subTitle = val.diamond.secondary;
                        } else if (tab.to === "SettingListPage") {
                            tab.label = val.setting.primary;
                            tab.subTitle = val.setting.secondary;
                        } else if (tab.to === "CompleteRingPage") {
                            tab.label = val.complete_ring.primary;
                            tab.subTitle = val.complete_ring.secondary;
                        }
                    });
                }
            },
        },
        getProductsData: {
            immediate: true,
            deep: true,
            handler(newVal) {
                this.tabs.forEach(tab => {
                    if (tab.to === "DiamondListPage") {
                        tab.selectedData = newVal?.diamond || {};
                    } else if (tab.to === "SettingListPage") {
                        tab.selectedData = newVal?.setting || {};
                    } else if (tab.to === "CompleteRingPage") {
                        if (this.isProductCompleted) {
                            const total_price = Number(newVal.diamond.price) + Number(newVal.setting.total_price)
                            if (total_price) {
                                tab.selectedData = { price: total_price };
                            } else {
                                tab.selectedData = {};
                            }
                        } else {
                            tab.selectedData = {};
                        }
                    }
                });
            }
        }
    },
}
</script>

<style scoped>
.tdprb-nav-controls {
    width: 40% !important;
    /* display: flex !important; */
    justify-content: center !important;
    align-items: start !important;
    flex-direction: column !important;
    width: auto !important;
    padding: 0 30px !important;
    border-left: 1px solid var(--border-color) !important;
}

.tdprb-nav-icon svg {
    width: 24px !important;
    /* Adjust size */
    height: 24px !important;
    /* Adjust size */
    fill: currentColor !important;
    /* Use current text color */
}


.tdprb-nav-center-side,
.tdprb-nav-left-side {
    position: relative !important;
    font-size: 20px !important;
    color: black !important;
    background: var(--background-color) !important;
}

.tdprb-nav-center-side div,
.tdprb-nav-left-side div {
    z-index: 2 !important;
}

.tdprb-nav-center-side:after {
    content: " " !important;
    position: absolute !important;
    display: block !important;
    width: 101% !important;
    height: 100% !important;
    top: 0 !important;
    right: 0 !important;
    z-index: 1 !important;
    background: var(--background-color) !important;
    border-left: 1px solid var(--border-color) !important;
    border-right: 1px solid var(--border-color) !important;
    transform-origin: bottom right !important;
    -ms-transform: skew(10deg, 0deg) !important;
    -webkit-transform: skew(10deg, 0deg) !important;
    transform: skew(-10deg, 0deg) !important;
}

.tdprb-nav-left-side:after {
    content: " " !important;
    position: absolute !important;
    display: block !important;
    width: 100% !important;
    height: 100% !important;
    top: 0 !important;
    right: 0 !important;
    z-index: 1 !important;
    background: var(--background-color) !important;
    border-right: 1px solid var(--border-color) !important;
    transform-origin: bottom left !important;
    -ms-transform: skew(-10deg, 0deg) !important;
    -webkit-transform: skew(-10deg, 0deg) !important;
    transform: skew(-10deg, 0deg) !important;
}

.tdprb-active-nav-tab-bg-before-after {
    background-color: var(--theme-color) !important;
}

.tdprb-active-nav-tab-bg-before-after::after {
    background-color: var(--theme-color) !important;
}
</style>