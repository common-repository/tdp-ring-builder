<template>
    <div
        class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-flex-col tdprb-gap-2 tdprb-justify-start tdprb-items-center tdprb-mt-[40px] md:tdprb-px-[30px] tdprb-px-[15px]">
        <template v-for="(product, index) in products" :key="index">
            <div
                class="tdprb-w-full md:tdprb-h-[140px] tdprb-h-[70px] tdprb-flex tdprb-justify-center tdprb-items-center tdprb-border tdprb-border-borderColor">
                <div
                    class="tdprb-h-full tdprb-w-[15%] tdprb-flex tdprb-justify-center tdprb-items-center tdprb-cursor-pointer">
                    <div :title="product.sub_category" class="tdprb-w-[120px] tdprb-aspect-square">
                        <Skeleton v-if="imageStates[index]?.isLoading" />
                        <DefaultImage v-else-if="imageStates[index]?.isError || !product.main_image" :type="'setting'"
                            :value="product.sub_category" :zoomScale="'tdprb-scale-90'" />
                        <img v-show="!imageStates[index]?.isLoading && !imageStates[index]?.isError && !!product.main_image"
                            @load="onLoad(index)" @error="onError(index)" :src="product.main_image"
                            :alt="product.sub_category" class="tdprb-h-full tdprb-w-full tdprb-object-cover" />
                    </div>
                </div>
                <div
                    class="tdprb-h-full tdprb-w-[80%] tdprb-flex tdprb-justify-around tdprb-items-center md:tdprb-py-[30px] tdprb-py-[15px]">
                    <div
                        class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-center tdprb-items-center tdprb-border-l tdprb-border-l-borderColor ms:tdprb-pl-[30px] tdprb-pl-[15px]">
                        <span
                            class="tdprb-font-lato tdprb-font-[500] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-text-[14px] tdprb-leading-[15px] tdprb-text-textSecondaryColor tdprb-w-full tdprb-text-left">
                            {{ product.product_name }}
                        </span>
                    </div>
                    <div
                        class="tdprb-w-full tdprb-h-full md:tdprb-flex tdprb-hidden tdprb-justify-center tdprb-items-center">
                        <span
                            class="tdprb-font-lato tdprb-font-[500] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-text-[14px] tdprb-leading-[15px] tdprb-text-textSecondaryColor">
                            {{ product.metal_name }}
                        </span>
                    </div>
                    <div class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-center tdprb-items-center">
                        <span
                            class="tdprb-font-lato tdprb-font-[500] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-text-[14px] tdprb-leading-[15px] tdprb-text-themeColor">
                            {{ roundOffPrice(product.total_price) }}
                        </span>
                    </div>
                </div>
                <div
                    class="tdprb-h-full tdprb-w-[5%] tdprb-flex tdprb-justify-center tdprb-items-center tdprb-pr-[20px]">
                    <span @click="getDetailPage(product)" class="tdprb-cursor-pointer">
                        <svg class="tdprb-h-[15px] tdprb-w-[10px] md:tdprb-h-[20px] md:tdprb-w-[12px]" width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M1.95617 2.20101e-05C2.14498 -0.00106898 2.33215 0.0351192 2.50694 0.106515C2.68174 0.177911 2.84073 0.283111 2.97478 0.416078L11.5828 9.02411C11.85 9.29291 12 9.65653 12 10.0356C12 10.4146 11.85 10.7782 11.5828 11.047L2.97478 19.655C2.70033 19.8901 2.34729 20.0129 1.98621 19.9989C1.62514 19.985 1.28263 19.8353 1.02712 19.5798C0.771616 19.3243 0.621933 18.9818 0.607986 18.6207C0.594039 18.2596 0.716857 17.9066 0.951894 17.6321L8.54131 10.0427L0.951895 2.45331C0.750436 2.2535 0.61275 1.99844 0.556245 1.72038C0.499739 1.44232 0.526955 1.15376 0.634449 0.891164C0.741942 0.628573 0.924887 0.403752 1.16015 0.245131C1.39541 0.0865107 1.67243 0.00121217 1.95617 2.20101e-05Z"
                                :fill="prussianBlue()" />
                        </svg>
                    </span>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        products: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            imageStates: this.products.map(() => ({
                isLoading: true,
                isError: false,
            })),
        };
    },
    methods: {
        prussianBlue() {
            return this.$colors().prussianBlue;
        },
        roundOffPrice(price) {
            return this.$roundToTwoDecimals(price);
        },
        onLoad(index) {
            this.imageStates[index] = { isLoading: false, isError: false };
        },
        onError(index) {
            this.imageStates[index] = { isLoading: false, isError: true };
        },
        getDetailPage(product) {
            this.$router.replace({
                name: 'SettingDetailPage',
                params: {
                    id: product.sku,
                },
            });
        },
    },
};
</script>