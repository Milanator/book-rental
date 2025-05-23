import { defineStore } from "pinia";
import axios from "@/plugins/axios";

export const useAuthorStore = defineStore("author", {
    state: () => ({
        authors: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchAll() {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get("/author");

                this.authors = response.data.data ?? response.data;
            } catch (err) {
                this.error = "Nepodarilo sa načítať autorov.";
                console.error(err);
            } finally {
                this.loading = false;
            }
        },
    },
});
