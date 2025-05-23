<script setup>
import { onMounted } from "vue";
import { useAuthorStore } from "@/store/author";

const authorStore = useAuthorStore();

onMounted(() => authorStore.fetchAll());
</script>

<template>
    <div v-for="author in authorStore.authors">
        {{ author.full_name }}
    </div>
</template>
