<script setup>
import FieldBuilder from "@/components/form/FieldBuilder.vue";
import { onMounted } from "vue";
import { useGeneralStore } from "@/store/general";

const props = defineProps({
    id: {
        type: [Number, undefined],
    },
    model: {
        type: String,
    },
});

const generalStore = useGeneralStore();

// fetch form fields
onMounted(() => generalStore.fetchFormBuilder(props.model, props.id));
</script>
<template>
    <template v-if="generalStore.formBuilder">
        <!-- Title -->
        <h1>{{ generalStore.formBuilder.title }}</h1>
        <!-- Subtitle -->
        <h2 v-if="generalStore.formBuilder.subtitle">
            {{ generalStore.formBuilder.subtitle }}
        </h2>
        <!-- Form fields -->
        <FieldBuilder
            v-for="field in generalStore.formBuilder.fields"
            :field="field"
        />
        <button>Uložiť</button>
    </template>
</template>
