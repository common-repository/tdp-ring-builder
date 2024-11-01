<template lang="">
    <div class="tdprb-w-full tdprb-h-full tdprb-flex md:tdprb-flex-row tdprb-flex-col tdprb-justify-center md:tdprb-items-start tdprb-items-center tdprb-gap-[20px]">
        <!-- image container  -->
       <div class="md:tdprb-h-[226px] tdprb-h-full tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center tdprb-border tdprb-border-borderColor">
        <Skeleton v-if="isLoading" />
        <DefaultImage v-else-if="isError" :type="'diamond'" :value="data.shape" :zoomScale="'tdprb-scale-125'" />
        <img  v-show="!isLoading && !isError" @load="onLoad" @error="onError" class="tdprb-h-full tdprb-w-full tdprb-object-cover" :src="data.image">
       </div>

       <!-- info container  -->
       <div class="md:tdprb-h-[226px] tdprb-h-full tdprb-w-full tdprb-flex tdprb-justify-around tdprb-items-start tdprb-flex-col">
            <div class="tdprb-w-full tdprb-h-auto tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-start">
                <p class="tdprb-font-poppins tdprb-w-[500] tdprb-text-[26px] tdprb-leading-[38px] tdprb-text-textPrimaryColor tdprb-mb-2" v-if="data.title">{{data.title}}</p>
                <p class="tdprb-font-lato tdprb-w-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-text-textSecondaryColor tdprb-mb-1" v-if="data.description">{{data.description}}</p>
                <p class="tdprb-font-lato tdprb-w-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-text-textSecondaryColor tdprb-mb-1" v-if="data.keyPoints">{{data.keyPoints}}</p>
                <p class="tdprb-font-lato tdprb-w-[400] tdprb-text-[15px] tdprb-leading-[18px] tdprb-text-textSecondaryColor" v-if="data.sku">SKU: {{data.sku}}</p>
            </div>
            <div class="tdprb-w-full tdprb-h-auto tdprb-flex  tdprb-justify-start tdprb-items-center">
                <div class="tdprb-w-[50%] tdprb-flex tdprb-justify-start tdprb-items-center tdprb-gap-[10px]">
                    <span
                        class="tdprb-flex tdprb-justify-center tdprb-items-center tdprb-font-poppins tdprb-text-[26px] tdprb-font-[500] tdprb-leading-[38px] tdprb-text-left tdprb-text-themeColor">
                        {{roundOffPrice(data.price)}}
                    </span>
                    <span  class="tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-lato tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[19.2px] tdprb-text-left tdprb-text-textSecondaryColor tdprb-line-through ">{{roundOffPrice(increasedPrice(data.price))}}</span>
                </div>
               
            </div>
            <div class="tdprb-w-full tdprb-h-auto tdprb-flex tdprb-justify-start tdprb-items-start tdprb-gap-4">
                <span @click="getDetailPage(data)" class="tdprb-flex tdprb-justify-center tdprb-items-end tdprb-font-lato tdprb-text-[16px] tdprb-font-[400] tdprb-leading-[19.2px] tdprb-text-left tdprb-text-themeColor tdprb-underline tdprb-underline-offset-4 tdprb-decoration-themeColor tdprb-cursor-pointer">Change</span>
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
        }
    },
    data() {
        return {
            isLoading: true, // Flag to track loading state
            isError: false, // Flag to track loading state
        }
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
        roundOffPrice(price) {
            return this.$roundToTwoDecimals(price)
        },
        increasedPrice(price) {
            return this.$increasePriceByPercentage(price, 20)
        },
        removeItem() {
            this.$store.dispatch('completeRing/removeDiamondData');
            this.$router.push({ name: 'DiamondListPage' })
        },
        diamondType(product) {
            return product?.diamond_type === 'w' || product?.diamond_type === 'W' ? 'natural' : 'labgrown'
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
    }
}
</script>
<style lang="">

</style>