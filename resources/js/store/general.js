import { defineStore } from "pinia";
import axios from "@/plugins/axios";
import { STATUS_ERROR, STATUS_SUCCESS } from "@/constants";

export const useGeneralStore = defineStore("general", {
    state: () => ({
        data: [],
        formBuilder: null,
        loaded: false,
        error: null,
        page: 1,
        id: undefined,
        model: undefined,
        flashMessage: undefined,
    }),

    actions: {
        getFormFieldValue(input) {
            if (input.type === "checkbox") {
                return input.checked;
            }

            return input.value;
        },

        setFlashMessage(message, status) {
            this.flashMessage = {
                status,
                message,
            };
        },

        setLoaded(loaded) {
            this.loaded = loaded;
        },

        setModel(model) {
            this.model = model;
        },

        setId(id) {
            this.id = id;
        },

        // get all form data
        getFormData() {
            const formData = new FormData();

            // laravel - PUT method
            if (this.id) {
                formData.append("_method", "PUT");
            }

            document
                .getElementById("form-builder")
                .querySelectorAll(`select,input,textarea`)
                .forEach((input) => {
                    formData.append(input.name, this.getFormFieldValue(input));
                });

            return formData;
        },

        async fetchAll() {
            this.error = null;

            try {
                const response = await axios.get(
                    `/${this.model}?page=${this.page}`
                );

                this.data = response.data;
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },

        async fetchSingle() {
            this.error = null;

            try {
                const response = await axios.get(`/${this.model}/${this.id}`);

                this.data = response.data.data;
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },

        async fetchFormBuilder() {
            this.error = null;

            try {
                // create or edit page
                const url = !this.id
                    ? `/${this.model}/form-builder`
                    : `/${this.model}/${this.id}/form-builder`;

                const response = await axios.get(url);

                this.formBuilder = response.data;
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },

        async submitForm() {
            this.error = null;

            try {
                // create or edit page
                const url = !this.id
                    ? `/${this.model}`
                    : `/${this.model}/${this.id}`;
                const data = this.getFormData();

                const response = await axios({
                    method: "POST",
                    url,
                    data,
                });

                this.data = response.data;

                this.setFlashMessage(response.data.message, STATUS_SUCCESS);
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },
    },
});
