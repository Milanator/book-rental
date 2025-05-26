<script setup>
import { useListing } from "@/composables/useListing";
import { useGeneralStore } from "@/store/general";

const props = defineProps({
    item: {
        type: Object,
    },
});

const generalStore = useGeneralStore();

const { deleteRow } = useListing();
</script>
<template>
    <!-- Edit -->
    <a :href="`/${generalStore.model}/${item.id}/edit`" class="px-2">
        Upraviť
    </a>
    <!-- Delete -->
    <a class="px-2" @click="deleteRow(item.id)"> Odstrániť </a>
</template>
