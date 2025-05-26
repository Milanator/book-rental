import { defineStore } from "pinia";
import axios from "@/plugins/axios";

export const useBookStore = defineStore("book", {
    state: () => ({
        data: [],
        error: null,
        page: null,
    }),

    actions: {
        async borrow(id) {
            this.error = null;

            try {
                return axios.get(`/book/${id}/borrow`);
            } catch (err) {
                this.error = "Nepodarilo sa zmeniť stav.";
                console.error(err);
            }
        },
    },
});
