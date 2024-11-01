<template lang="">
    <div v-html="getImage()" class="tdprb-object-cover tdprb-w-full tdprb-h-full tdprb-flex tdprb-justify-center tdprb-items-center" :class="zoomScale" />
</template>
<script>
export default {
    props: {
        type: {
            type: String,
            default: ''
        },
        value: {
            type: String,
            default: 'N/A'
        },
        zoomScale: {
            type: String,
            default: 'tdprb-scale-150'
        },
        shapeSize:{
            type: Number,
            default: 50
        }
    },
    methods:{
        getImage(){
            return this.type == 'setting' ? this.$getRingStyles(this.value) : this.type == 'diamond' ? this.$getDiamondShapes(this.value,false,this.shapeSize) : value;
        }
    }
}
</script>
<style lang="">

</style>