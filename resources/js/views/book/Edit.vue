<script setup>
import Layout from "@/layouts/Layout.vue";
import FormBuilder from "@/components/Form/FormBuilder.vue";
import { useGeneralStore } from "@/store/general";
import { onMounted } from "vue";

const props = defineProps({
    id: {
        type: [Number, undefined],
    },
});

const generalStore = useGeneralStore();

const model = "book";

onMounted(() => generalStore.fetchFormBuilder(model, props.id));
</script>
<template>
    <Layout>
        <FormBuilder
            v-if="generalStore.formBuilder"
            :form-builder="generalStore.formBuilder"
        />
    </Layout>
</template>
