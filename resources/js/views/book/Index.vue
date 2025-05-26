<script setup>
import Filter from "@/views/book/Filter.vue";
import ListingBuilder from "@/components/listing/ListingBuilder.vue";
import RowActions from "@/components/listing/RowActions.vue";
import BorrowAction from "@/views/book/BorrowAction.vue";

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
                Vytvoriť knihu
            </a>
        </template>

        <!-- Actions in table row -->
        <template #row-actions="{ item }">
            <!-- Base row actions -->
            <RowActions :item="item" />
            <!-- Borrow -->
            <BorrowAction :item="item" />
        </template>
    </ListingBuilder>
</template>
