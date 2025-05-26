<script setup>
import Layout from "@/layouts/Layout.vue";
import FormBuilder from "@/components/Form/FormBuilder.vue";
</script>
<template>
    <Layout>
        <FormBuilder
            :form-builder="{
                title: 'Testujem nadpis',
                fields: [{ type: 'Text', name: 'title' }],
            }"
        />
    </Layout>
</template>
