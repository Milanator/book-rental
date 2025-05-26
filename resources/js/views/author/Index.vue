<script setup>
import Filter from "@/views/author/Filter.vue";
import ListingBuilder from "@/components/listing/ListingBuilder.vue";

const props = defineProps({
    model: {
        type: String,
    },
});
</script>
<template>
    <ListingBuilder :model="model">
        <!-- Filter -->
        <template #filter>
            <Filter />
        </template>

        <!-- Table actions -->
        <template #table-actions>
            <a :href="`/${model}/create`" class="btn btn-primary my-3">
                Vytvoriť autora
            </a>
        </template>
    </ListingBuilder>
</template>
