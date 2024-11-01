<template>
    <div class="tdprb-h-[450px] tdprb-max-w-[383px] tdprb-w-full  tdprb-border tdprb-border-borderColor tdprb-flex tdprb-flex-col tdprb-justify-center tdprb-items-center  tdprb-gap-[30px] tdprb-relative tdprb-group tdprb-overflow-hidden tdprb-p-[10px]"
        @click="getDetailPage(product)">

        <!-- hover affected container  -->
        <div @click="getDetailPage(product)"
            class="tdprb-absolute tdprb-left-0 tdprb-top-0 tdprb-right-0 tdprb-bottom-0 tdprb-transition-all tdprb-duration-300 tdprb-ease-linear tdprb-scale-y-0 tdprb-origin-bottom group-hover:tdprb-scale-y-100 tdprb-z-10">
            <div
                class="tdprb-h-full tdprb-w-full tdprb-bg-backgroundColor tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-center tdprb-gap-1 tdprb-opacity-90 tdprb-cursor-pointer tdprb-p-[20px] tdprb-overflow-hidden">
                <template v-for="(value, key, index) in hoverDetails" :key="index">
                    <div v-if="key == 'product_description'"
                        class="tdprb-w-full tdprb-grid tdprb-grid-cols-1">
                        <div
                            class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-lato tdprb-text-[16px] tdprb-font-[600] tdprb-text-textPrimaryColor tdprb-leading-[24px]">
                            {{ value }} :
                        </div>
                        <div
                            class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-text-textPrimaryColor tdprb-leading-[24px]">
                            {{ product[key] || '-' }}
                        </div>
                    </div>
                    <div v-else class="tdprb-w-full tdprb-grid tdprb-grid-cols-2">
                        <div
                            class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-lato tdprb-text-[16px] tdprb-font-[600] tdprb-text-textPrimaryColor tdprb-leading-[24px]">
                            {{ value }} :
                        </div>
                        <div
                            class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-text-textPrimaryColor tdprb-leading-[24px] tdprb-uppercase tdprb-overflow-hidden tdprb-text-ellipsis ">
                            {{ sentenceCase(product[key]) || '-' }}
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- image container  -->

        <div
            class="tdprb-h-[260px] tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center tdprb-overflow-hidden">
            <Skeleton v-if="isLoading" />
            <DefaultImage v-else-if="isError" :type="'setting'" :value="product.sub_category" />
            <img  :src="product.main_image" v-show="!isLoading && !isError" @load="onLoad" @error="onError"
                class="tdprb-object-cover tdprb-w-full tdprb-h-full">
        </div>

        <!-- title container  -->
        <div
            class="tdprb-h-[34px] tdprb-min-w-[190px] tdprb-flex tdprb-flex-col tdprb-justify-center tdprb-items-center tdprb-gap-1">
            <span
                class="tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-center tdprb-uppercase tdprb-text-textSecondaryColor">{{
                    title[0] }}</span>
            <span
                class="tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-center tdprb-uppercase tdprb-text-textSecondaryColor">{{
                    title[1] }}</span>
        </div>

        <!-- price container -->
        <div>
            <span
                class="tdprb-font-lato tdprb-text-[22px] tdprb-font-[500] tdprb-leading-[30px] tdprb-text-center tdprb-text-themeColor">{{
                    roundOffPrice(product.total_price) }} (Setting Price)</span>
        </div>

    </div>
</template>
<script>
export default {
    props: {
        product: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            isLoading: true, // Flag to track loading state
            isError: false, // Flag to track loading state
            hoverDetails: {
                sku: 'Report No.',
                category: 'Category',
                sub_category: 'Ring Style',
                metal_name: 'Metal',
                product_name: 'Product Name	',
                // product_description: 'Description	',
            }
        }
    },
    computed: {
        title() {
            return this.product.product_name.split('-');
        }
    },
    mounted() {
        this.checkImageCache(this.product.main_image);
    },
    methods: {
        checkImageCache(imageSrc) {
            const img = new Image();
            img.src = imageSrc;

            // If the image is already cached, it will trigger the `onLoad` immediately
            if (img.complete) {
                this.onLoad();
            } else {
                this.isLoading = true;
            }
        },
        roundOffPrice(price) {
            return this.$roundToTwoDecimals(price)
        },
        increasedPrice(price) {
            return this.$increasePriceByPercentage(price, 20)
        },
        sentenceCase(data) {
            return this.$toSentenceCase(data);
        },
        onLoad() {
            this.isLoading = false; // Hide loader when content is loaded
            this.isError = false; // Hide loader when content is loaded
        },
        onError() {
            this.isLoading = false; // Handle error and hide loader
            this.isError = true; // Handle error and hide loader
        },
        getDetailPage(product) {
            this.$router.replace({
                name: 'SettingDetailPage',
                params: {
                    id: product.sku,
                }
            });
        },
    },
}
</script>
<style lang="">

</style>