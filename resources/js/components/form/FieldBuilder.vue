<script setup>
import { computed, defineAsyncComponent } from "vue";

const props = defineProps(["field"]);

const component = computed(() =>
    defineAsyncComponent(() =>
        import(`@/components/form/fields/${props.field.type}.vue`)
    )
);
</script>
<template>
    <component :is="component" :field="field" />
</template>
