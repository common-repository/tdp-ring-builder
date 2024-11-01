<template lang="">
  <div
    v-if="products.length > 0"
    class="tdprb-h-full tdprb-w-full tdprb-grid tdprb-place-content-center tdprb-place-items-center md:tdprb-grid-cols-3 sm:tdprb-grid-cols-2 tdprb-grid-cols-1 tdprb tdprb-gap-5 tdprb-mx-auto tdprb-py-[40px] md:tdprb-px-[30px] tdprb-px-[15px] lg:tdprb-grid-cols-4"
    :style="isDesktop && { gridTemplateColumns: `repeat(${items_per_row}, minmax(0, 1fr))` }"
  >
    <template v-for="(product, index) in products" :key="index">
      <DiamondGridViewCard :product="product" />

      <!-- Insert advertisement every 4 items -->
      <template v-if="!!advertisement && (index + 1) % (advertisement?.interval - 1) === 0">
        <DiamondAdvertisementCard :advertisement="advertisement" />
      </template>
</template>
</div>
</template>

<script>
export default {
    props: {
        products: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            isDesktop: false,
            advertisement: null
        };
    },
    computed: {
        items_per_row() {
            return (
                this.$store.getters["diamondFilters/getFilterValue"]("items_per_row") ||
                4
            );
        },
        list_advertisement_links() {
            return this.$store.getters['generalSettings/getGeneralSettingByKey']('list_advertisement_links');
        },
    },
    mounted() {
        window.addEventListener("resize", this.handleScreenSize);
        this.handleScreenSize(); // Call on initial render to set the initial screen size state
    },
    destroyed() {
        window.removeEventListener("resize", this.handleScreenSize);
    },
    methods: {
        handleScreenSize() {
            this.isDesktop = window.innerWidth >= 1024;
        },
    },
    watch: {
        list_advertisement_links: {
            handler(newVal) {
                if (newVal.diamond_list_ad) {
                    if (!!newVal.diamond_list_ad?.interval && !!newVal.diamond_list_ad?.link && !!newVal.diamond_list_ad?.redirect_link) {
                        this.advertisement = {
                            interval: newVal.diamond_list_ad?.interval,
                            link: newVal.diamond_list_ad?.link,
                            redirect_link: newVal.diamond_list_ad?.redirect_link,
                        }
                    } else {
                        this.advertisement = null
                    }

                } else {
                    this.advertisement = null
                }
            },
            deep: true,
            immediate: true
        }
    }
};
</script>
