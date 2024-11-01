<template>
    <div
        class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-flex-col tdprb-justify-start tdprb-items-start tdprb-gap-[20px] tdprb-pt-[20px] tdprb-mt-[20px] tdprb-border-t tdprb-border-t-borderColor">
        <div class="tdprb-w-full">
            <p
                class="tdprb-font-lato tdprb-text-[22px] tdprb-font-[500] tdprb-leading-[30px] tdprb-text-left tdprb-text-themeColor">
                Diamond Information</p>
        </div>
        <div class="tdprb-w-full tdprb-min-h-50px tdprb-grid md:tdprb-grid-cols-2 tdprb-grid-cols-1">
            <template v-for="(value, index) in headers" :key="index">
                <div
                    class="tdprb-w-full tdprb-h-[42px] tdprb-flex tdprb-px-[30px] tdprb-gap-[20px] tdprb-border tdprb-border-borderColor">
                    <div
                        class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-between tdprb-items-center tdprb-font-poppins tdprb-text-[14px] tdprb-font-[500] tdprb-leading-[21px] tdprb-text-left tdprb-text-themeColor">
                        <span>{{ value.text }}</span><span>:</span>
                    </div>
                    <div
                        class="tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-start tdprb-items-center tdprb-font-poppins tdprb-text-[14px] tdprb-font-[400] tdprb-leading-[21px] tdprb-text-left tdprb-text-textSecondaryColor">
                        <span v-if="value.text == 'Measurement'">
                            {{ data['length'].toFixed(2) + ' x ' + data['width'].toFixed(2) + ' x ' +
                                data['depth'].toFixed(2) || '-' }}
                        </span>
                        <span v-else-if="value.text == 'Price'">
                            {{ roundOffPrice(data['price']) || '-' }}
                        </span>
                        <span v-else-if="value.text == 'L/W Ratio'">
                            {{ (data['length'] / data['width']).toFixed(2) || '-' }}
                        </span>
                        <span v-else-if="value.text == 'Table' || value.text == 'Depth' || value.text == 'Girdle'">
                            {{ symbolForm(data[value.key], ' %') || '-' }}
                        </span>
                        <span v-else-if="value.text == 'Polish' || value.text == 'Cut'">
                            {{ fullForm(data[value.key]) || '-' }}
                        </span>
                        <span v-else>
                            {{ Array.isArray(data[value.key]) ? data[value.key].join(', ') : data[value.key] || '-' }}
                        </span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        headers: {
            type: Object,
            required: true
        },
        data: {
            type: Object,
            required: true
        }
    },
    methods: {
        roundOffPrice(price) {
            return this.$roundToTwoDecimals(price)
        },
        increasedPrice(price) {
            return this.$increasePriceByPercentage(price, 20)
        },
        fullForm(value) {
            return this.$getCutFullForm(value);
        },
        symbolForm(value, symbol) {
            return this.$setSymbol(value, symbol);
        }
    },
}
</script>
<style scoped></style>