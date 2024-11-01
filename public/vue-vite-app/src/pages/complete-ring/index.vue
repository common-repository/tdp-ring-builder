<template lang="">
    <Alert v-show="addToCartVar.error" :message="addToCartVar.message" />
    <Loader v-if="isLoading" containerClass="tdprb-h-screen" />
    <Error v-else-if="dataNotFound || products.length <= 0" :message="dataNotFoundMsg" containerClass="tdprb-h-screen" />
    <div v-else class="tdprb-w-full tdprb-h-full  tdprb-gap-2 md:tdprb-px-[30px] tdprb-px-[15px]">

        <!-- title  -->
        <div class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-mt-[20px] tdprb-mb-[10px] md:tdprb-mt-[40px] md:tdprb-mb-[20px]">
            <span class="tdprb-font-lato tdprb-font-[500] tdprb-text-[16px] tdprb-leading-[20px] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-text-themeColor">My Cart ({{itemsCount}} items)</span>
        </div>

        <!-- main container  -->
        <div class="tdprb-w-full tdprb-h-full tdprb-flex md:tdprb-flex-row tdprb-flex-col  tdprb-gap-[25px] ">
            <div class="md:tdprb-w-[70%] tdprb-w-full tdprb-h-full">

                <!--product carts title  -->
                <div class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-mb-[20px]">
                    <span class="tdprb-font-lato tdprb-font-[500] tdprb-text-[16px] tdprb-leading-[20px] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-text-textSecondaryColor">{{configTexts.complete_rings_texts}} (Completed)</span>
                 </div>

                 <!-- product list  -->
                <div class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-center tdprb-gap-[30px] tdprb-p-[20px] tdprb-border tdprb-border-borderColor">
                    <SettingProductCard v-if="products?.setting" :data="products?.setting"  :configTexts="configTexts" :ringSizeError="ringSizeError" />
                    <DiamondProductCard v-if="products?.diamond" :data="products?.diamond"  :configTexts="configTexts" />
                </div>

            </div>
            <div class="md:tdprb-w-[30%] tdprb-w-full tdprb-h-full">

                <!-- Order Summary title  -->
                <div class="tdprb-w-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-mb-[20px]">
                    <span
                        class="tdprb-font-lato tdprb-font-[500] tdprb-text-[16px] tdprb-leading-[20px] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-text-textSecondaryColor">{{configTexts.order_summary}}</span>
                </div>

                <!-- order summary detail  -->
                <div
                    class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-center tdprb-gap-[20px] tdprb-p-[20px] tdprb-border tdprb-border-borderColor">
                    <OrderSummary :configTexts="configTexts" :data="products" @addToCart="addToCart" :addToCartVar="addToCartVar"  />
                </div>

                <!-- Book an In-Person Appointment & Book a Virtual Consultation buttons  -->
                <div
                    class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-flex-col tdprb-justify-center tdprb-items-center tdprb-gap-[20px] tdprb-mt-[20px]">
                    <button @click="openLink(configPageLinks.book_appointment_link)"
                        class="tdprb-w-full tdprb-h-[60px]  tdprb-flex tdprb-justify-center  tdprb-gap-[20px] tdprb-items-center tdprb-text-backgroundColor tdprb-bg-themeColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-rounded tdprb-font-lato tdprb-text-[16px] tdprb-leading-[20px] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-font-[500] tdprb-text-center tdprb-group">
                        <span>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="tdprb-fill-backgroundColor group-hover:tdprb-fill-themeColor"
                                    d="M28.125 9.375V6.5625C28.125 5.81658 27.8287 5.10121 27.3012 4.57376C26.7738 4.04632 26.0584 3.75 25.3125 3.75H21.5625V2.8125C21.5625 2.56386 21.4637 2.3254 21.2879 2.14959C21.1121 1.97377 20.8736 1.875 20.625 1.875C20.3764 1.875 20.1379 1.97377 19.9621 2.14959C19.7863 2.3254 19.6875 2.56386 19.6875 2.8125V3.75H10.3125V2.8125C10.3125 2.56386 10.2137 2.3254 10.0379 2.14959C9.8621 1.97377 9.62364 1.875 9.375 1.875C9.12636 1.875 8.8879 1.97377 8.71209 2.14959C8.53627 2.3254 8.4375 2.56386 8.4375 2.8125V3.75H4.6875C3.94158 3.75 3.22621 4.04632 2.69876 4.57376C2.17132 5.10121 1.875 5.81658 1.875 6.5625V9.375H28.125Z"
                                    fill="none" />
                                <path class="tdprb-fill-backgroundColor group-hover:tdprb-fill-themeColor"
                                    d="M1.875 11.25V25.3125C1.875 26.0584 2.17132 26.7738 2.69876 27.3012C3.22621 27.8287 3.94158 28.125 4.6875 28.125H25.3125C26.0584 28.125 26.7738 27.8287 27.3012 27.3012C27.8287 26.7738 28.125 26.0584 28.125 25.3125V11.25H1.875ZM20.2969 16.6491L13.7344 22.2741C13.555 22.4274 13.3244 22.5075 13.0886 22.4983C12.8527 22.4891 12.6291 22.3913 12.4622 22.2244L9.64969 19.4119C9.47891 19.2351 9.38442 18.9982 9.38656 18.7524C9.38869 18.5066 9.48729 18.2715 9.66111 18.0977C9.83493 17.9239 10.0701 17.8253 10.3159 17.8231C10.5617 17.821 10.7985 17.9155 10.9753 18.0862L13.1747 20.2856L19.0809 15.2231C19.1739 15.1393 19.2827 15.075 19.4009 15.0339C19.5191 14.9929 19.6443 14.9759 19.7692 14.984C19.8941 14.992 20.0161 15.0251 20.128 15.081C20.2399 15.137 20.3395 15.2148 20.4209 15.3099C20.5022 15.405 20.5638 15.5154 20.6018 15.6346C20.6398 15.7539 20.6536 15.8795 20.6423 16.0041C20.631 16.1287 20.5949 16.2498 20.536 16.3603C20.4772 16.4707 20.3968 16.5683 20.2997 16.6472L20.2969 16.6491Z"
                                    fill="none" />
                            </svg>
                        </span>
                        <span>Book an In-Person Appointment</span>
                    </button>
                    <button @click="openLink(configPageLinks.virtual_consultation_link)"
                        class="tdprb-w-full tdprb-h-[60px]  tdprb-flex tdprb-justify-center  tdprb-gap-[20px] tdprb-items-center tdprb-text-backgroundColor tdprb-bg-themeColor hover:tdprb-text-themeColor hover:tdprb-bg-backgroundColor hover:tdprb-border hover:tdprb-border-borderColor tdprb-rounded tdprb-font-lato tdprb-text-[16px] tdprb-leading-[20px] md:tdprb-text-[22px] md:tdprb-leading-[30px] tdprb-font-[500] tdprb-text-center tdprb-group">
                        <span>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="tdprb-fill-backgroundColor group-hover:tdprb-fill-themeColor" d="M14.9999 13.745L20.2997 10.6853L14.9999 7.62549L9.7002 10.6853L14.9999 13.745Z"
                                    fill="none" />
                                <path class="tdprb-fill-backgroundColor group-hover:tdprb-fill-themeColor" d="M15.8694 6.11959L22.908 10.1833V18.3108L28.2076 21.3705V7.12354L15.8694 0V6.11959Z"
                                    fill="none" />
                                <path class="tdprb-fill-backgroundColor group-hover:tdprb-fill-themeColor" d="M14.1305 15.251L8.83081 12.1912V18.3108L14.1305 21.3705V15.251Z" fill="none" />
                                <path class="tdprb-fill-backgroundColor group-hover:tdprb-fill-themeColor"
                                    d="M27.3383 22.8765L22.0386 19.8167L15 23.8804L7.96137 19.8167L2.66174 22.8765L15 30L27.3383 22.8765Z"
                                    fill="none" />
                                <path class="tdprb-fill-backgroundColor group-hover:tdprb-fill-themeColor" d="M21.1691 12.1912L15.8694 15.251V21.3705L21.1691 18.3108V12.1912Z" fill="none" />
                                <path class="tdprb-fill-backgroundColor group-hover:tdprb-fill-themeColor" d="M7.09192 18.3108V10.1833L14.1305 6.11959V0L1.79224 7.12354V21.3705L7.09192 18.3108Z"
                                    fill="none" />
                            </svg>
                        </span>
                        <span>Book a Virtual Consultation</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return {
            configTexts: {},
            configPageLinks: {},
            addToCartVar: {
                timer: null,
                loading: false,
                error: false,
                message: null,
            },
            isLoading: true, // Flag to track loading state
            ringSizeError: false, // Flag to track
            products: {},
            itemsCount: 0,
        }
    },
    computed: {
        finalProducts() {
            return this.$store.getters['completeRing/getProductsData'];
        },
        completeRingsTexts() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('complete_rings_texts');
        },
        detailsPageLinks() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('details_page_links');
        },
    },
    methods: {
        async addToCart() {

            this.addToCartVar.loading = true;
            this.addToCartVar.error = false;
            this.addToCartVar.message = null;

            const actionUrl = this.$isDevelopmentMode ? this.$defaultAjaxUrl : tdprbajax.ajaxurl;
            const data = new FormData();
            data.append('action', this.$apiActions.completeRingAddToCartApi);
            !this.$isDevelopmentMode && data.append("nonce", tdprbajax.nonce);
            data.append('completeRingData', JSON.stringify(this.products));

            try {
                const response = await axios.post(actionUrl, data);
                this.addToCartVar.loading = false;

                if (response.data.status) {
                    if (!!response.data.cart_url) {
                        window.location.href = response.data.cart_url;
                    } else {
                        this.addToCartVar.loading = false;
                        this.addToCartVar.message = response.data.message;
                        console.error('product url not found');
                    }
                } else {
                    this.addToCartVar.error = true;
                    this.addToCartVar.message = response.data.message;
                    console.error(response.data.message);
                }
            } catch (error) {
                this.addToCartVar.loading = false;
                this.addToCartVar.error = true;
                this.addToCartVar.message = error;
                console.error(error);
            }
        },
        openLink(link) {
            window.open(link, '_blank');
        }
    },
    watch: {
        'addToCartVar.error': {
            handler(val) {
                if (val) {
                    clearTimeout(this.addToCartVar.timer);
                    this.addToCartVar.timer = setTimeout(() => {
                        this.addToCartVar.error = false;
                        this.addToCartVar.message = null;
                    }, 2000);
                }
            },
            immediate: true,
            deep: true
        },
        finalProducts: {
            deep: true,
            immediate: true,
            handler(val) {
                if (Object.keys(val.diamond).length && Object.keys(val.setting).length) {
                    this.isLoading = false;
                    this.products = val;
                    this.itemsCount = Object.keys(val).length
                }
            }
        },
        completeRingsTexts: {
            deep: true,
            immediate: true,
            handler(newTexts, oldTexts) {
                this.configTexts = newTexts;
            }
        },
        detailsPageLinks: {
            deep: true,
            immediate: true,
            handler(newTexts, oldTexts) {
                this.configPageLinks = newTexts;
            }
        }
    }
}

</script>
<style lang="">

</style>