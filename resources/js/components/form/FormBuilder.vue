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

generalStore.id = props.id;

generalStore.model = props.model;

// fetch form fields
onMounted(() => generalStore.fetchFormBuilder());

const submitForm = (event) => {
    event.preventDefault();

    generalStore.submitForm();
};
</script>
<template>
    <form
        v-if="generalStore.formBuilder"
        id="form-builder"
        @submit="submitForm"
    >
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
    </form>
</template>
