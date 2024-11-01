<template>
    <div>
        <RouterView />
    </div>
</template>

<script setup>
import { onMounted } from 'vue';

onMounted(() => {
    // const loaderElement = document.getElementById('tdp-rb-initial-loader');
    // if (loaderElement) {
    //     loaderElement.style.display = 'none';
    // }
});
</script>

<style scoped>
/* Add styles specific to this component if needed */
</style>