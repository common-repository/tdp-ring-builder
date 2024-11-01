<template lang="">
    <div class="tdprb-w-full tdprb-flex tdprb-justify-center tdprb-items-center"  :class="containerClass"  >
        <span class="tdprb-text-themeColor tdprb-text-2xl tdprb-font-lato tdprb-font-bold">{{message}}</span>
    </div>
</template>
<script>
export default {
    props:{
      containerClass:{
        type: String,
        default:'tdprb-h-full'
      },
      message:{
        type: String,
        default:''
      }
    }
}
</script>
<style lang="">
    
</style>