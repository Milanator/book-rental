import { defineStore } from "pinia";
import axios from "@/plugins/axios";
import { STATUS_ERROR, STATUS_SUCCESS } from "@/constants";

export const useGeneralStore = defineStore("general", {
    state: () => ({
        data: [],
        formBuilder: null,
        listingBuilder: null,
        loaded: false,
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
        getFormData(id) {
            const formData = new FormData();

            // laravel - PUT method
            if (this.id) {
                formData.append("_method", "PUT");
            }

            document
                .getElementById(id)
                .querySelectorAll(`select,input,textarea`)
                .forEach((input) => {
                    console.log(input.name, this.getFormFieldValue(input));
                    formData.append(input.name, this.getFormFieldValue(input));
                });

            return formData;
        },

        getErrorMessages(errors) {
            return Object.values(errors).join("<br/>");
        },

        async fetchAll() {
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
            try {
                const response = await axios.get(`/${this.model}/${this.id}`);

                this.data = response.data.data;
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },

        async fetchFormBuilder() {
            try {
                // create or edit page
                const url = !this.id
                    ? `/${this.model}/form-builder`
                    : `/${this.model}/form-builder/${this.id}`;

                const response = await axios.get(url);

                this.formBuilder = response.data;
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },

        async fetchListingBuilder() {
            try {
                const url = `/${this.model}/listing-builder`;

                const response = await axios.get(url);

                this.listingBuilder = response.data;
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },

        async deleteSingle(id) {
            try {
                const url = `/${this.model}/${id}`;

                const response = await axios.delete(url);

                this.setFlashMessage(response.data.message, STATUS_SUCCESS);

                return response;
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },

        async fetchFilter() {
            this.page = 1;

            try {
                const url = `/${this.model}`;

                const params = Object.fromEntries(
                    this.getFormData("filter").entries()
                );

                const response = await axios({
                    method: "GET",
                    url,
                    params,
                });

                this.data = response.data;

                return response;
            } catch (err) {
                this.setFlashMessage(err, STATUS_ERROR);
            }
        },

        async submitForm() {
            try {
                // create or edit page
                const url = !this.id
                    ? `/${this.model}`
                    : `/${this.model}/${this.id}`;
                const data = this.getFormData("form-builder");

                const response = await axios({
                    method: "POST",
                    url,
                    data,
                });

                this.data = response.data;

                this.setFlashMessage(response.data.message, STATUS_SUCCESS);
            } catch (err) {
                if (err.response?.data?.errors) {
                    // field validation
                    this.setFlashMessage(
                        this.getErrorMessages(err.response.data.errors),
                        STATUS_ERROR
                    );
                } else {
                    // general error
                    this.setFlashMessage(err, STATUS_ERROR);
                }
            }
        },
    },
});
