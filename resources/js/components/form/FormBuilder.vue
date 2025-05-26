<script setup>
import FieldBuilder from "@/components/form/FieldBuilder.vue";
import { onMounted } from "vue";
import { useGeneralStore } from "@/store/general";
import { useForm } from "@/composables/useForm";

const props = defineProps({
    id: {
        type: [Number, undefined],
    },
    model: {
        type: String,
    },
});

const generalStore = useGeneralStore();

const { fetchFormData, submitForm } = useForm();

generalStore.setModel(props.model);

generalStore.setId(props.id);

// fetch form fields and model
onMounted(fetchFormData);
</script>
<template>
    <form v-if="generalStore.loaded" id="form-builder" @submit="submitForm">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <template
                    v-for="breadcrumb in generalStore.formBuilder.breadcrumb"
                >
                    <!-- Link -->
                    <li v-if="breadcrumb.url" class="breadcrumb-item">
                        <a :href="breadcrumb.url">{{ breadcrumb.label }}</a>
                    </li>
                    <!-- Label -->
                    <li
                        v-else
                        class="breadcrumb-item active"
                        aria-current="page"
                    >
                        {{ breadcrumb.label }}
                    </li>
                </template>
            </ol>
        </nav>

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
        <button type="submit" class="btn btn-primary">Uložiť</button>
    </form>
</template>
