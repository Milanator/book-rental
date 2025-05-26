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

const { setupForm, submitForm } = useForm();

onMounted(() => setupForm(props));
</script>
<template>
    <form v-if="generalStore.loaded" id="form-builder" @submit="submitForm">
        <!-- Breadcrumb -->
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

        <!-- Form fields -->
        <FieldBuilder
            v-for="field in generalStore.formBuilder.fields"
            :field="field"
        />
        
        <button type="submit" class="btn btn-primary">Uložiť</button>
    </form>
</template>
