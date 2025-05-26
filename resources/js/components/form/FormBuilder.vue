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

generalStore.setModel(props.model)

generalStore.setId(props.id)

// fetch form fields and model
onMounted(() => {
    generalStore.fetchFormBuilder().then(async () => {
        if (generalStore.id) {
            // edit page
           await generalStore.fetchSingle();
        }

        generalStore.setLoaded(true)
    });
});

const submitForm = (event) => {
    event.preventDefault();

    generalStore.submitForm();
};
</script>
<template>
    <form
        v-if="generalStore.loaded"
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
