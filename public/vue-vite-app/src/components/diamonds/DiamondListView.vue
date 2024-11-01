<template>
    <div
        class="tdprb-h-full tdprb-min-w-full  tdprb-flex tdprb-flex-col tdprb-mx-auto tdprb-justify-start tdprb-items-center tdprb-overflow-x-auto">
        <!-- header  -->
        <div
            class="tdprb-min-w-full tdprb-h-[60px] tdprb-border-b tdprb-border-b-borderColor tdprb-grid tdprb-items-center tdprb-grid-flow-col">
            <template v-for="(header, index) in headerData" :key="index">
                <div class="tdprb-min-w-[100px] tdprb-flex tdprb-justify-center tdprb-items-center">
                    <span
                        class="tdprb-font-lato tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[19.2px] tdprb-text-center tdprb-text-themeColor ">{{
                            header.text }}</span>
                    <!-- <span class="tdprb-font-lato tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[19.2px] tdprb-text-center tdprb-text-themeColor ">{{header.slice(0,1).toUpperCase() + header.slice(1).toLowerCase() || "-"}}</span> -->
                </div>
            </template>
            <div class="tdprb-min-w-[100px] tdprb-flex tdprb-justify-center tdprb-items-center" />
        </div>
        <!-- body  -->
        <template v-for="(product, index) in bodyData" :key="index">
            <div
                class="tdprb-min-w-full tdprb-h-[60px] tdprb-border-b tdprb-border-b-borderColor tdprb-grid tdprb-items-center tdprb-grid-flow-col">
                <template v-for="(header, index) in headerData" :key="index">
                    <div v-if="header.text == 'View'"
                        class="tdprb-min-w-[100px] tdprb-flex tdprb-justify-center tdprb-items-center tdprb-gap-3">
                        <span class="tdprb-cursor-pointer">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_220_319)">
                                    <path
                                        d="M0.69557 20.4121L0.67157 20.4361C0.34757 19.7281 0.14357 18.9241 0.0595703 18.0361C0.14357 18.9121 0.37157 19.7041 0.69557 20.4121Z"
                                        :fill="prussianBlue()" />
                                    <path
                                        d="M8.39995 10.056C9.97732 10.056 11.2559 8.77731 11.2559 7.19999C11.2559 5.62267 9.97732 4.34399 8.39995 4.34399C6.82262 4.34399 5.54395 5.62267 5.54395 7.19999C5.54395 8.77731 6.82262 10.056 8.39995 10.056Z"
                                        :fill="prussianBlue()" />
                                    <path
                                        d="M17.028 0H6.972C2.604 0 0 2.604 0 6.972V17.028C0 18.336 0.228 19.476 0.672 20.436C1.704 22.716 3.912 24 6.972 24H17.028C21.396 24 24 21.396 24 17.028V14.28V6.972C24 2.604 21.396 0 17.028 0ZM22.044 12.6C21.108 11.796 19.596 11.796 18.66 12.6L13.668 16.884C12.732 17.688 11.22 17.688 10.284 16.884L9.876 16.548C9.024 15.804 7.668 15.732 6.708 16.38L2.22 19.392C1.956 18.72 1.8 17.94 1.8 17.028V6.972C1.8 3.588 3.588 1.8 6.972 1.8H17.028C20.412 1.8 22.2 3.588 22.2 6.972V12.732L22.044 12.6Z"
                                        :fill="prussianBlue()" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_220_319">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <span class="tdprb-cursor-pointer">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_220_324)">
                                    <path
                                        d="M23.8815 8.78822L19.96 2.48761C19.8167 2.25755 19.565 2.11768 19.2941 2.11768H4.706C4.43516 2.11768 4.1834 2.25755 4.0401 2.48761L0.118571 8.78822C-0.0696772 9.0907 -0.0307244 9.48182 0.213727 9.7409L11.4293 21.6359C11.5775 21.7931 11.7841 21.8822 12 21.8822C12.216 21.8822 12.4225 21.7931 12.5707 21.6357L23.7863 9.7409C24.0305 9.48154 24.0698 9.0907 23.8815 8.78822ZM12.0001 19.9547L1.76954 9.10429L5.1418 3.68629H18.8585L22.2306 9.10429L12.0001 19.9547Z"
                                        :fill="prussianBlue()" />
                                    <path d="M23.2159 8.41821H0.784668V9.98683H23.2159V8.41821Z" :fill="prussianBlue()" />
                                    <path
                                        d="M8.05659 9.12757L9.266 3.0552L7.72744 2.74878L6.47256 9.04939C6.44303 9.1984 6.45713 9.35266 6.51362 9.49385L11.2718 21.3892L12.7282 20.8067L8.05659 9.12757Z"
                                        :fill="prussianBlue()" />
                                    <path
                                        d="M17.5777 8.98651L16.2705 2.8689L14.7367 3.19674L15.9939 9.07983L11.2729 20.8052L12.7278 21.3908L17.5385 9.44349C17.5965 9.29841 17.6104 9.13918 17.5777 8.98651Z"
                                        :fill="prussianBlue()" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_220_324">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                    </div>
                    <template v-else-if="headerData.length === index + 1">
                        <div class="tdprb-min-w-[100px] tdprb-flex tdprb-justify-center tdprb-items-center">
                            <span
                                class="tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-center tdprb-text-textSecondaryColor">{{
                                    header.key == 'price' ? roundOffPrice(product[header.key]) : product[header.key]

                                        || "-" }}</span>
                        </div>
                        <div class="tdprb-min-w-[100px] tdprb-flex tdprb-justify-center tdprb-items-center ">
                            <button @click="getDetailPage(product)"
                                class="tdprb-border tdprb-border-themeColor tdprb-rounded tdprb-h-[36px] tdprb-w-[95px] tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-center tdprb-bg-backgroundColor tdprb-text-themeColor hover:tdprb-bg-themeColor hover:tdprb-text-backgroundColor">View</button>
                        </div>
                    </template>
                    <div v-else class="tdprb-min-w-[100px] tdprb-flex tdprb-justify-center tdprb-items-center">
                        <span
                            class="tdprb-font-lato tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[16.8px] tdprb-text-center tdprb-text-textSecondaryColor">{{
                                header.key == 'price' ? roundOffPrice(product[header.key]) : product[header.key]
                                    || "-" }}</span>
                    </div>
                </template>
            </div>
        </template>
    </div>
</template>
<script>

export default {
    data() {
        return {
            headerData: [],
            bodyData: [],
        }
    },
    props: {
        products: {
            type: Array,
            required: true
        }
    },
    computed: {
        listViewCustomization() {
            return this.$store.getters['diamondSettings/listViewCustomization']
        },
        title(product) {
            return `${product?.shape} ${product?.carat} ${product?.color} ${product?.clarity} ${product?.symmetry}`;
        }
    },
    methods: {
        prussianBlue() {
            return this.$colors().prussianBlue;
        },
        roundOffPrice(price) {
            return this.$roundToTwoDecimals(price)
        },
        diamondType(product) {
            return product?.diamond_type === 'w' || product?.diamond_type === 'W' ? 'natural' : 'labgrown'
        },
        getDetailPage(product) {
            this.$router.replace({
                name: 'DiamondDetailPage',
                params: {
                    id: product.sku,
                    type: this.diamondType(product)
                }
            });
        }
    },
    watch: {
        listViewCustomization: {
            handler(value) {
                this.headerData = value;
            },
            immediate: true,
            deep: true
        },
        products: {
            handler(value) {
                this.bodyData = value;
            },
            immediate: true,
            deep: true
        }
    }
}
</script>
<style lang="">

</style>