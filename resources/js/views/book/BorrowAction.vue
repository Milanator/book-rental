<script setup>
import { useBook } from "@/composables/useBook";

const props = defineProps({
    item: {
        type: Object,
    },
});

const { borrowBook } = useBook();
</script>
<template>
    <!-- Borrow -->
    <a v-if="item.is_borrowed" class="px-2" @click="borrowBook(item.id)">
        Vrátiť
    </a>
    <a v-else class="px-2" @click="borrowBook(item.id)"> Požičať </a>
</template>
