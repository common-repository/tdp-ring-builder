<template lang="">
    <div class="tdprb-h-[450px] tdprb-max-w-[383px] tdprb-w-full tdprb-flex tdprb-flex-col tdprb-justify-center tdprb-items-center  tdprb-gap-[30px] tdprb-relative tdprb-group tdprb-overflow-hidden tdprb-cursor-pointer" :title="advertisement?.redirect_link" @click="openLink(advertisement?.redirect_link)" >
        <!-- Shine effect, only visible and animates once on hover -->
        <div class="tdprb-absolute tdprb-top-0 tdprb-w-full tdprb-h-full tdprb-bg-shine-gradient tdprb-opacity-0 group-hover:tdprb-opacity-100 group-hover:tdprb-animate-shine-hover-once tdprb-transition-opacity"></div>
        <div class="tdprb-h-full tdprb-w-full tdprb-flex tdprb-justify-center tdprb-items-center tdprb-overflow-hidden">
            <Skeleton v-if="isLoading" />
            <img :src="advertisement?.link" v-show="!isLoading" @load="onLoad" @error="onError"
                class="tdprb-object-cover tdprb-w-full tdprb-h-full">
        </div>
    </div>
</template>
<script>
export default {
    props: {
        advertisement: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            isLoading: true
        }
    },
    mounted() {
        this.checkImageCache(this.advertisement?.link);
    },
    methods: {
        openLink(link) {
            window.open(link, '_blank');
        },
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
        onLoad() {
            this.isLoading = false; // Hide loader when content is loaded
        },
        onError() {
            this.isLoading = false; // Handle error and hide loader
        },
    }
}
</script>
<style lang="">

</style>