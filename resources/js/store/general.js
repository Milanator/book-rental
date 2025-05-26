import { defineStore } from "pinia";
import axios from "@/plugins/axios";
import { STATUS_ERROR, STATUS_SUCCESS } from "@/constants";

export const useGeneralStore = defineStore("general", {
    state: () => ({
        data: [],
        formBuilder: null,
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

        setSuccessMessage(message, status) {
            this.flashMessage = {
                status,
                message,
            };
        },

        // get all form data
        getFormData(id) {
            const formData = new FormData();

            // laravel - PUT method
            if (id) {
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
                this.setSuccessMessage(
                    "Nepodarilo sa načítať dáta.",
                    STATUS_ERROR
                );
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
                this.setSuccessMessage(
                    "Nepodarilo sa načítať dáta.",
                    STATUS_ERROR
                );
            }
        },

        async submitForm(id = null) {
            this.error = null;

            try {
                // create or edit page
                const url = !id ? `/${this.model}` : `/${this.model}/${id}`;
                const method = !id ? "POST" : "PUT";
                const data = this.getFormData(id);

                const response = await axios({
                    method,
                    url,
                    data,
                });

                this.data = response.data;

                this.setSuccessMessage(response.data.message, STATUS_SUCCESS);
            } catch (err) {
                this.setSuccessMessage(
                    "Nepodarilo sa načítať dáta.",
                    STATUS_ERROR
                );
            }
        },
    },
});
