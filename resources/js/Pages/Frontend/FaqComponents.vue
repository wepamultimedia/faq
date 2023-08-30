<script>
import MainLayout from "@pages/Vendor/Core/Frontend/Layouts/MainLayout/MainLayout.vue";

export default {
    layout: (h, page) => h(MainLayout, () => page)
};
</script>
<script setup>

import LatestFaq from "@//Vendor/Faq/Components/LatestFaq.vue";
</script>

<template>
<LatestFaq></LatestFaq>
</template>

<style scoped>

</style>
