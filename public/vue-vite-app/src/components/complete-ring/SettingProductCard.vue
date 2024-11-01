<template lang="">
    <div class="tdprb-w-full tdprb-h-full tdprb-flex md:tdprb-flex-row tdprb-flex-col tdprb-justify-center md:tdprb-items-start tdprb-gap-[20px]">
        <!-- image container  -->
       <div class="md:tdprb-h-[226px] tdprb-h-full tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center tdprb-border tdprb-border-borderColor">
        <Skeleton v-if="isLoading" />
        <DefaultImage v-else-if="isError" :type="'setting'" :value="data.sub_category"  :zoomScale="'tdprb-scale-125'"  />
        <img  v-show="!isLoading && !isError" @load="onLoad" @error="onError" class="tdprb-h-full tdprb-w-full tdprb-object-cover" :src="data.main_image">
       </div>

       <!-- info container  -->
       <div class="md:tdprb-h-[226px] tdprb-h-full tdprb-w-full tdprb-flex tdprb-justify-around tdprb-items-start tdprb-flex-col">
            <div class="tdprb-w-full tdprb-h-auto tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-start">
                <p class="tdprb-font-poppins tdprb-w-[500] tdprb-text-[26px] tdprb-leading-[38px] tdprb-text-textPrimaryColor tdprb-mb-2" v-if="data.product_name">{{data.product_name}}</p>
                <div @click="isFullDescription = !isFullDescription" class="tdprb-font-lato tdprb-w-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-text-textSecondaryColor tdprb-mb-2 " :class="isFullDescription ? 'tdprb-line-clamp-2' : ''" v-if="data.product_description" v-html="data.product_description"></div>
                <!-- <p class="tdprb-font-lato tdprb-w-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-text-textSecondaryColor" v-if="data.sku">SKU: {{data.sku}}</p> -->
                <p class="tdprb-font-lato tdprb-w-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-text-textSecondaryColor" v-if="data.selectedMetal">{{data.selectedMetal}}</p>
            </div>
            <div class="tdprb-w-full tdprb-h-auto tdprb-flex md:tdprb-flex-row tdprb-flex-col tdprb-justify-start tdprb-items-start tdprb-gap-2">
                <div class="tdprb-w-[50%] tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-[10px]">
                    <span
                        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-poppins tdprb-text-[26px] tdprb-font-[500] tdprb-leading-[38px] tdprb-text-left tdprb-text-themeColor">
                        {{roundOffPrice(data.total_price)}}
                    </span>
                    <span  class="tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-lato tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[19.2px] tdprb-text-left tdprb-text-textSecondaryColor tdprb-line-through ">{{roundOffPrice(increasedPrice(data.total_price))}}</span>
                </div>
                <div class="tdprb-w-[50%] tdprb-flex tdprb-justify-start tdprb-items-center ">
                    <Dropdown :defaultText="configTexts.ring_size_text" @setDropDownValue="updateRingSize"
                            :selectedOption="selectedRingSize" :options="ringSizeData" />
                    <div v-show="ringSizeError"
                    class="tdprb-text-red-500 tdprb-h-5 tdprb-flex tdprb-justify-start tdprb-items-center tdprb-w-full tdprb-p-2">
                    Please Select Ring Size</div>
                </div>
            </div>
            <div class="tdprb-w-full tdprb-h-auto tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-2 tdprb-cursor-pointer">
                <span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.3251 7.09166L15.5668 8.85L11.1501 4.43333L12.9084 2.675C13.044 2.52262 13.2082 2.39849 13.3918 2.30971C13.5754 2.22094 13.7747 2.16926 13.9783 2.15765C14.1819 2.14604 14.3858 2.17472 14.5783 2.24204C14.7708 2.30937 14.9481 2.41402 15.1001 2.55L17.4501 4.9C17.5861 5.05198 17.6907 5.22929 17.7581 5.42179C17.8254 5.61428 17.8541 5.81817 17.8425 6.02177C17.8308 6.22537 17.7792 6.42468 17.6904 6.60827C17.6016 6.79186 17.4775 6.95613 17.3251 7.09166ZM11.1501 6.2L10.2668 5.31666L3.15844 12.425C2.8674 12.7062 2.68451 13.0809 2.64177 13.4833L2.29177 17.025C2.28491 17.1116 2.29593 17.1986 2.32415 17.2808C2.35237 17.3629 2.39717 17.4384 2.45579 17.5025C2.51441 17.5666 2.58558 17.6179 2.66488 17.6533C2.74419 17.6887 2.82993 17.7075 2.91677 17.7083H2.97511L6.51677 17.3583C6.91924 17.3156 7.29386 17.1327 7.57511 16.8417L14.6834 9.73333L13.8001 8.85L11.1501 6.2Z" :fill="outerSpace()"/>
                    </svg>                        
                </span>
                <input type="text" v-model="engravingTexts" placeholder="Add free engraving" class="tdprb-w-[150px] tdprb-bg-backgroundColor tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-lato tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[19.2px] tdprb-text-left tdprb-text-textSecondaryColor tdprb-p-2  tdprb-border-b" />
            </div>
            <div class="tdprb-w-full tdprb-h-auto tdprb-flex tdprb-justify-start tdprb-items-start tdprb-gap-4">
                <span @click="getDetailPage(data)"  class="tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-lato tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[19.2px] tdprb-text-left tdprb-text-themeColor tdprb-underline tdprb-underline-offset-4 tdprb-decoration-themeColor tdprb-cursor-pointer">Change</span>
                <span class="tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-lato tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[19.2px] tdprb-text-left tdprb-text-themeColor">|</span>
                <span @click="removeItem" class="tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-lato tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[19.2px] tdprb-text-left tdprb-text-themeColor tdprb-underline tdprb-underline-offset-4 tdprb-decoration-themeColor tdprb-cursor-pointer">Remove</span>
            </div>
       </div>
    </div>
</template>
<script>


export default {
    props: {
        data: {
            type: Array,
        },
        configTexts: {
            type: Object,
        },
        ringSizeError: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            engravingTexts: null,
            selectedRingSize: null,
            ringSizeData: [],
            isFullDescription: true,
            isLoading: true, // Flag to track loading state
            isError: false, // Flag to track loading state
        }
    },
    computed: {
        ringSizeCountryCode() {
            return this.$store.getters['settingSettings/ringSize']
        },
    },
    methods: {
        onLoad() {
            this.isLoading = false; // Hide loader when content is loaded
            this.isError = false; // Handle error and hide loader
        },
        onError() {
            this.isLoading = false; // Handle error and hide loader
            this.isError = true; // Handle error and hide loader
        },
        outerSpace() {
            return this.$colors().outerSpace
        },
        roundOffPrice(price) {
            return this.$roundToTwoDecimals(price)
        },
        increasedPrice(price) {

            return this.$increasePriceByPercentage(price, 20)
        },
        getRingSizeData(countryCode) {
            return this.$getRingSizesByCountry(countryCode)
        },
        updateRingSize(value) {
            this.selectedRingSize = value
        },
        updateSettingData(field, value) {
            const changedData = this.data
            changedData[field] = value
            this.$store.dispatch('completeRing/setSettingData', changedData);
        },
        removeItem() {
            this.$store.dispatch('completeRing/removeSettingData');
            this.$router.push({ name: 'SettingListPage' })
        },
        getDetailPage(product) {
            this.$router.push({
                name: product.toName,
                params: {
                    id: product.sku,
                }
            })
        },
    },
    watch: {
        ringSizeCountryCode: {
            immediate: true,
            handler(value) {
                if (!!value) {
                    this.ringSizeData = this.getRingSizeData(value)
                }
            }
        },
        selectedRingSize: {
            immediate: true,
            handler(value) {
                if (!!value) {
                    this.updateSettingData('selectedRingSize', value)
                }
            }
        },
        engravingTexts: {
            immediate: true,
            handler(value) {
                if (!!value) {
                    this.updateSettingData('engravingTexts', value)
                }
            }
        },
        data: {
            deep: true,
            handler(newVal,) {
                if (!!newVal) {
                    this.selectedRingSize = newVal?.selectedRingSize
                    this.engravingTexts = newVal?.engravingTexts
                }
            },
            immediate: true,
            deep: true,
        }
    }
}
</script>
<style lang="">

</style>