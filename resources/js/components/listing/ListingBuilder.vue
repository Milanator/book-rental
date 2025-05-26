<script setup>
import Layout from "@/layouts/Layout.vue";
import { onMounted } from "vue";
import { useGeneralStore } from "@/store/general";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import { useListing } from "@/composables/useListing";
import RowActions from "@/components/listing/RowActions.vue";

const props = defineProps({
    model: {
        type: String,
    },
});

const generalStore = useGeneralStore();

const { changePage, setupListing } = useListing();

onMounted(() => setupListing(props));
</script>
<template>
    <Layout>
        <template v-if="generalStore.loaded">
            <!-- Title -->
            <h5 class="card-title">{{ generalStore.listingBuilder.title }}</h5>

            <!-- Filder -->
            <slot name="filter"></slot>

            <!-- Table actions -->
            <slot name="table-actions"></slot>

            <!-- Table -->
            <table class="table">
                <!-- Head -->
                <thead>
                    <tr>
                        <!-- Columns -->
                        <th
                            v-for="column in generalStore.listingBuilder
                                .columns"
                            scope="col"
                        >
                            {{ column.label }}
                        </th>
                        <!-- Actions -->
                        <th scope="col">Akcie</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody>
                    <tr v-for="item in generalStore.data.data">
                        <!-- Columns -->
                        <slot
                            v-for="column in generalStore.listingBuilder
                                .columns"
                            :name="column.name"
                            :value="item[column.name]"
                        >
                            <td>{{ item[column.name] }}</td>
                        </slot>
                        <!-- Actions -->
                        <td>
                            <slot name="row-actions" :item="item">
                                <!-- Base row actions -->
                                <RowActions :item="item" />
                            </slot>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <bootstrap5-pagination
                :data="generalStore.data"
                @pagination-change-page="changePage"
            />
        </template>
    </Layout>
</template>
