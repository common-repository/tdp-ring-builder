<template>
    <div
        class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-start tdprb-gap-[20px] tdprb-pt-[20px] tdprb-mt-[20px] tdprb-border-t tdprb-border-t-borderColor">
        <div class="tdprb-w-full">
            <p
                class="tdprb-font-lato tdprb-text-[22px] tdprb-font-[500] tdprb-leading-[30px] tdprb-text-left tdprb-text-themeColor">
                Ring Information</p>
        </div>
        <div class="tdprb-w-full tdprb-min-h-50px tdprb-grid tdprb-grid-cols-1">
            <template v-for="(value, key, index) in headers" :key="index">
                <div class="tdprb-w-full tdprb-h-[42px] tdprb-flex  tdprb-gap-[20px] ">
                    <div
                        class="tdprb-w-1/4 tdprb-h-full tdprb-flex tdprb-justify-between tdprb-items-center tdprb-font-poppins tdprb-text-[14px] tdprb-font-[500] tdprb-leading-[21px] tdprb-text-left tdprb-text-themeColor">
                        <span>{{ value }}</span><span>:</span>
                    </div>
                    <div v-if="key == 'diamond_can_be_matched_with'"
                        class="tdprb-w-3/4 tdprb-h-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-poppins tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[21px] tdprb-text-left tdprb-text-textSecondaryColor">
                        <span> {{ getMatchedDiamonds(data[key]) }}</span>
                    </div>
                    <div v-else
                        class="tdprb-w-3/4 tdprb-h-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-poppins tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[21px] tdprb-text-left tdprb-text-textSecondaryColor">
                        <span> {{ Array.isArray(data[key]) ? data[key].join(', ') : data[key] }}</span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script>

export default {
    props: {
        data: {
            type: Object,
            default: {}
        }
    },
    data() {
        return {
            headers: {
                sku: 'SKU',
                sub_category: 'Setting Style',
                // metal: 'Sizes Available',
                // size: 'Width Range',
                diamond_can_be_matched_with: 'Can be set with',
                metal_name: 'Metal',
            }

        }
    },
    computed: {
        toSentenceCase() {
            return (value) => {
                return this.$toSentenceCase(value);
            }
        }
    },
    methods: {
        getMatchedDiamonds(data) {
            return data.split(',').map(d => this.$setting_can_be_set_with_shapes[d - 1]).join(', ');
        }
    },
}
</script>
<style scoped></style>