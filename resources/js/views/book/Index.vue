<script setup>
import Layout from "@/layouts/Layout.vue";
import { onMounted } from "vue";
import { useBookStore } from "@/store/book";
import { Bootstrap5Pagination } from "laravel-vue-pagination";

const bookStore = useBookStore();

onMounted(() => bookStore.fetchAll());
</script>

<template>
    <Layout>
        <h5 class="card-title py-4">Knihy</h5>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Názov</th>
                    <th scope="col">Author</th>
                    <th scope="col">Požičaná</th>
                    <th scope="col">Akcie</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="book in bookStore.data.data">
                    <th scope="row">{{ book.id }}</th>
                    <td>{{ book.title }}</td>
                    <td>{{ book.author }}</td>
                    <td>{{ book.is_borrowed }}</td>
                    <td>
                        <a :href="`/book/${book.id}/edit`" class="px-2">
                            Upraviť
                        </a>
                        <a href="#" class="px-2"> Odstrániť </a>
                        <a
                            v-if="book.is_borrowed"
                            class="px-2"
                            @click="bookStore.borrow(book.id)"
                        >
                            Vrátiť
                        </a>
                        <a
                            v-else
                            class="px-2"
                            @click="bookStore.borrow(book.id)"
                        >
                            Požičať
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <bootstrap5-pagination
            :data="bookStore.data"
            @pagination-change-page="bookStore.fetchAll"
        />
    </Layout>
</template>
