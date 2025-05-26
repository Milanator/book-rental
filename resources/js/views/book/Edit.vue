<script setup>
import Layout from "@/layouts/Layout.vue";
import FormBuilder from "@/components/Form/FormBuilder.vue";

const props = defineProps({
    id: {
        type: [Number, undefined],
    },
    model: {
        type: String,
    },
});
</script>
<template>
    <Layout>
        <FormBuilder :id="id" :model="model" />
    </Layout>
</template>
