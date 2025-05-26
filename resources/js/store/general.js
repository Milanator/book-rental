import { defineStore } from "pinia";
import axios from "@/plugins/axios";

export const useGeneralStore = defineStore("general", {
    state: () => ({
        data: [],
        formBuilder: null,
        loading: false,
        error: null,
        page: 1,
    }),

    actions: {
        async fetchAll(model) {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get(`/${model}?page=${this.page}`);

                this.data = response.data;
            } catch (err) {
                this.error = "Nepodarilo sa načítať dáta.";
                console.error(err);
            } finally {
                this.loading = false;
            }
        },

        async fetchFormBuilder(model, id = null) {
            this.loading = true;
            this.error = null;

            try {
                // create or edit page
                const url = !id
                    ? `/${model}/form-builder`
                    : `/${model}/${id}/form-builder`;

                const response = await axios.get(url);

                this.formBuilder = response.data;
            } catch (err) {
                this.error = "Nepodarilo sa načítať dáta.";
                console.error(err);
            } finally {
                this.loading = false;
            }
        },
    },
});
