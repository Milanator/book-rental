import { defineStore } from "pinia";
import axios from "@/plugins/axios";

export const useBookStore = defineStore("book", {
    state: () => ({
        data: [],
        error: null,
        page: null,
    }),

    actions: {
        async fetchAll(page = 1) {
            this.error = null;
            this.page = page;

            try {
                const response = await axios.get(`/book?page=${page}`);

                this.data = response.data;
            } catch (err) {
                this.error = "Nepodarilo sa načítať autorov.";
                console.error(err);
            }
        },

        async borrow(book) {
            this.error = null;

            try {
                axios
                    .get(`/book/${book}/borrow`)
                    .then(() => this.fetchAll(this.page));
            } catch (err) {
                this.error = "Nepodarilo sa zmeniť stav.";
                console.error(err);
            }
        },
    },
});
