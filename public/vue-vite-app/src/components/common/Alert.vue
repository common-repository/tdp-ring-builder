<template lang="">
    <div v-if="type == 'success'" class="tdprb-z-50 tdprb-h-screen tdprb-w-screen tdprb-fixed tdprb-top-0 tdprb-left-0 tdprb-flex tdprb-justify-center tdprb-items-center">
        <div class="tdprb-bg-green-100 tdprb-border tdprb-border-green-400 tdprb-text-green-700 tdprb-px-4 tdprb-py-3 tdprb-rounded">
              <strong class="tdprb-font-bold">{{message}}</strong>
        </div>
    </div>
    <div v-else-if="type == 'info'" class="tdprb-z-50 tdprb-h-screen tdprb-w-screen tdprb-fixed tdprb-top-0 tdprb-left-0 tdprb-flex tdprb-justify-center tdprb-items-center">
        <div class="tdprb-bg-blue-100 tdprb-border tdprb-border-blue-400 tdprb-text-blue-700 tdprb-px-4 tdprb-py-3 tdprb-rounded">
              <strong class="tdprb-font-bold">{{message}}</strong>
        </div>
    </div>
    <div v-else class="tdprb-z-50 tdprb-h-screen tdprb-w-screen tdprb-fixed tdprb-top-0 tdprb-left-0 tdprb-flex tdprb-justify-center tdprb-items-center">
        <div class="tdprb-bg-red-100 tdprb-border tdprb-border-red-400 tdprb-text-red-700 tdprb-px-4 tdprb-py-3 tdprb-rounded">
              <strong class="tdprb-font-bold">{{message}}</strong>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        },
        type: {
            type: String,
        },
    },

}
</script>
<style lang="">

</style>