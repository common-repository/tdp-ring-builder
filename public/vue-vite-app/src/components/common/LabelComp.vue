<template lang="">
    <div
    class="tdprb-flex tdprb-items-center tdprb-justify-start tdprb-gap-[10px]">
        <span class="tdprb-flex tdprb-items-center tdprb-justify-center tdprb-font-lato tdprb-text tdprb-text-[16px] tdprb-font-[500] tdprb-leading-[19.2px] tdprb-text-textPrimaryColor">
            {{ title || 'Label'}}
        </span>
        <span ref="tdprbToolTip" class="tdprb-flex tdprb-items-center tdprb-justify-center tdprb-relative">
            <svg class="tdprb-cursor-pointer" @click="toggleTooltip"  width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_162_2456)">
                    <path
                        d="M10 0C4.47301 0 0 4.4725 0 10C0 15.5269 4.4725 20 10 20C15.527 20 20 15.5275 20 10C20 4.47309 15.5275 0 10 0ZM11.0269 13.9696C11.0269 14.2855 10.5662 14.6014 10.0002 14.6014C9.40785 14.6014 8.98668 14.2855 8.98668 13.9696V8.95445C8.98668 8.5859 9.40789 8.33574 10.0002 8.33574C10.5662 8.33574 11.0269 8.5859 11.0269 8.95445V13.9696ZM10.0002 7.12484C9.39473 7.12484 8.9209 6.6773 8.9209 6.17707C8.9209 5.67687 9.39477 5.2425 10.0002 5.2425C10.5926 5.2425 11.0665 5.67687 11.0665 6.17707C11.0665 6.6773 10.5925 7.12484 10.0002 7.12484Z"
                        :fill="prussianBlue()" />
                </g>
                <defs>
                    <clipPath id="clip0_162_2456">
                        <rect width="20" height="20" :fill="prussianBlue()" />
                    </clipPath>
                </defs>
            </svg>
            <Tooltip  v-if="title == activeTooltip" :title="title" :description="description" @closeTooltip="closeTooltip" />
        </span>
    </div>
</template>
<script>
export default {
    props: ['title','description'],
    data() {
        return {
            activeTooltip: null,
        }
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    },
    methods: {
        prussianBlue() {
            return this.$colors().prussianBlue
        },
        toggleTooltip() {
            this.activeTooltip = this.activeTooltip == this.title ? null : this.title;
        },
        closeTooltip() {
            this.activeTooltip = null;
        },
        handleClickOutside(event) {
            if (this.$refs.tdprbToolTip && !this.$refs.tdprbToolTip.contains(event.target)) {
                this.closeTooltip()
            }
        },
    },
    beforeDestroy() {
        document.removeEventListener('click', this.handleClickOutside);
    },
}
</script>
<style lang="">

</style>