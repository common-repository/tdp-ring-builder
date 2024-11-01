<template>
    <div class="tdprb-h-[450px] tdprb-max-w-[383px] tdprb-w-full  tdprb-border tdprb-border-borderColor tdprb-flex tdprb-flex-col tdprb-justify-center tdprb-items-center  tdprb-gap-[30px] tdprb-relative tdprb-group tdprb-overflow-hidden tdprb-p-[10px]" 
        @click="getDetailPage(product)">
        <!-- hover affected container  -->
        <div
            class="tdprb-absolute tdprb-left-0 tdprb-top-0 tdprb-right-0 tdprb-bottom-0 tdprb-transition-all tdprb-duration-300 tdprb-ease-linear tdprb-scale-y-0 tdprb-origin-bottom group-hover:tdprb-scale-y-100 tdprb-z-10 tdprb-overflow-hidden" @click="getDetailPage(product)">
            <div
                class="tdprb-h-full tdprb-w-full tdprb-bg-backgroundColor tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-center tdprb-gap-1 tdprb-opacity-90 tdprb-cursor-pointer tdprb-p-[20px] tdprb-overflow-hidden">
                <template v-for="(value, key, index) in hoverDetails" :key="index">
                    <div class="tdprb-w-full tdprb-grid tdprb-grid-cols-2 tdprb-overflow-hidden">
                        <div
                            class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-lato tdprb-text-[16px] tdprb-font-[600] tdprb-text-textPrimaryColor tdprb-leading-[24px]">
                            {{ value }} :
                        </div>
                        <div
                            class="tdprb-w-full tdprb-text-start tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-text-textPrimaryColor tdprb-leading-[24px] tdprb-uppercase tdprb-text-ellipsis  tdprb-overflow-hidden">
                            {{
                                key == 'diamond_type' ? diamondType(product)
                                    : key == 'measurements' ? getMeasurements(product)
                                        : key == 'price' ? roundOffPrice(product[key])
                                            : key == 'cut' || key == 'symmetry' || key == 'polish' ? fullForm(product[key])
                                                : product[key] || '-'
                            }}
                        </div>
                    </div>
                </template>
            </div>
        </div>


        <!-- image container  -->

        <div
            class="tdprb-h-[260px] tdprb-aspect-square tdprb-flex tdprb-justify-center tdprb-items-center tdprb-overflow-hidden">
            <Skeleton v-if="isLoading" />
            <DefaultImage v-else-if="isError" :type="'diamond'" :value="product.shape" />
            <img :src="product.image" v-show="!isLoading && !isError" @load="onLoad" @error="onError"
                class="tdprb-object-cover tdprb-w-full tdprb-h-full">
        </div>

        <!-- title container  -->
        <div
            class="tdprb-h-[34px] tdprb-min-w-[190px] tdprb-flex tdprb-flex-col tdprb-justify-center tdprb-items-center tdprb-gap-1">
            <span
                class="tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-center tdprb-uppercase tdprb-text-textSecondaryColor">{{
                    title }}</span>
            <span
                class="tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-center tdprb-uppercase tdprb-text-textSecondaryColor">{{
                    product.lab }}</span>
        </div>

        <!-- price container -->
        <div>
            <span
                class="tdprb-font-lato tdprb-text-[22px] tdprb-font-[500] tdprb-leading-[30px] tdprb-text-center tdprb-text-themeColor">{{
                    roundOffPrice(product.price) }}</span>
        </div>

    </div>
</template>
<script>
export default {
    props: {
        product: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            isLoading: true, // Flag to track loading state
            isError: false, // Flag to track loading state
            hoverDetails: {
                sku: 'Report No.',
                diamond_type: 'Diamond Type',
                shape: 'Shape',
                carat: 'Carat (ct.)',
                color: 'Color',
                clarity: 'Clarity',
                cut: 'Cut',
                polish: 'Polish',
                symmetry: 'Symmetry',
                lab: 'Lab',
                fluorescence: 'Fluorescence',
                measurements: 'Measurements (mm)',
                price: 'Price ($)',
            }
        }
    },
    computed: {
        title() {
            return `${this.product?.shape} ${this.product?.carat} ${this.product?.color} ${this.product?.clarity} ${this.product?.symmetry}`;
        }
    },
    mounted() {
        this.checkImageCache(this.product.image);
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
        onLoad() {
            this.isLoading = false; // Hide loader when content is loaded
            this.isError = false; // Hide loader when content is loaded
        },
        onError() {
            this.isLoading = false; // Handle error and hide loader
            this.isError = true; // Handle error and hide loader
        },
        diamondType(product) {
            return product?.diamond_type === 'w' || product?.diamond_type === 'W' ? 'natural' : 'labgrown'
        },
        getMeasurements(product) {
            return `${product['length']?.toFixed(2)} x ${product['width']?.toFixed(2)} x ${product['depth']?.toFixed(2)}`
        },
        getDetailPage(product) {
            this.$router.replace({
                name: 'DiamondDetailPage',
                params: {
                    id: product.sku,
                    type: this.diamondType(product)
                }
            });
        },
        fullForm(value) {
            return this.$getCutFullForm(value);
        },
    },
}
</script>
<style lang="">

</style>