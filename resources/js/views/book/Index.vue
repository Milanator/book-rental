<script setup>
import { onMounted } from "vue";
import { useBookStore } from "@/store/book";

const bookStore = useBookStore();

onMounted(() => bookStore.fetchAll());
</script>

<template>
    <div v-for="book in bookStore.books">
        {{ book.title }}
    </div>
</template>
