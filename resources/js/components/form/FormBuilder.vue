<script setup>
import FieldBuilder from "@/components/form/FieldBuilder.vue";

const props = defineProps({
    formBuilder: {
        type: Object,
    },
});
</script>
<template>
    <h1>{{ formBuilder.title }}</h1>
    <h2 v-if="formBuilder.subtitle">{{ formBuilder.subtitle }}</h2>
    <FieldBuilder v-for="field in formBuilder.fields" :field="field" />
    <button>Uložiť</button>
</template>
