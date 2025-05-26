<script setup>
import Layout from "@/layouts/Layout.vue";
import { onMounted } from "vue";
import { useGeneralStore } from "@/store/general";
import { useBookStore } from "@/store/book";
import { Bootstrap5Pagination } from "laravel-vue-pagination";
import { useListing } from "@/composables/useListing";

const props = defineProps({
    model: {
        type: String,
    },
});

const generalStore = useGeneralStore();

const bookStore = useBookStore();

const { deleteRow, changePage } = useListing();

generalStore.setModel(props.model);

onMounted(() => generalStore.fetchAll());

const borrowBook = (id) => {
    bookStore.borrow(id).then(() => generalStore.fetchAll());
};
</script>
<template>
    <Layout>
        <h5 class="card-title">Knihy</h5>

        <a href="/book/create">Vytvoriť knihu</a>

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
                <tr v-for="book in generalStore.data.data">
                    <th scope="row">{{ book.id }}</th>
                    <td>{{ book.title }}</td>
                    <td>{{ book.author }}</td>
                    <td>{{ book.is_borrowed }}</td>
                    <td>
                        <a :href="`/book/${book.id}/edit`" class="px-2">
                            Upraviť
                        </a>
                        <a class="px-2" @click="deleteRow(book.id)">
                            Odstrániť
                        </a>
                        <a
                            v-if="book.is_borrowed"
                            class="px-2"
                            @click="borrowBook(book.id)"
                        >
                            Vrátiť
                        </a>
                        <a v-else class="px-2" @click="borrowBook(book.id)">
                            Požičať
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <bootstrap5-pagination
            :data="generalStore.data"
            @pagination-change-page="changePage"
        />
    </Layout>
</template>
