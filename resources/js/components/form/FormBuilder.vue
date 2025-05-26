<script setup>
import FieldBuilder from "@/components/form/FieldBuilder.vue";

const props = defineProps(["formBuilder"]);
</script>
<template>
    <h1>Page title</h1>
    <h2>Page subtitle</h2>
    <FieldBuilder v-for="field in formBuilder.fields" :field="field" />
</template>
