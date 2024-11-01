<template lang="">
    <div class="tdprb-skeleton-loader" :class="classNames" />
</template>
<script>
export default {
    props: {
        classNames: {
            type: String,
            default: () => 'tdprb-h-full tdprb-w-full'
        }
    }
}
</script>
