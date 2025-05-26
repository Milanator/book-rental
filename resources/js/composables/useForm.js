import { get } from "lodash";
import { useGeneralStore } from "@/store/general";
import { ref } from "vue";

export function useForm() {
    const generalStore = useGeneralStore();

    // find value by dotted path
    const getFieldValue = (path) => ref(get(generalStore.data, path));

    // load form builder and model (if edit)
    const setupForm = (props) => {
        generalStore.setModel(props.model);

        generalStore.setId(props.id);

        generalStore.fetchFormBuilder().then(async () => {
            if (generalStore.id) {
                // edit page
                await generalStore.fetchSingle();
            }

            generalStore.setLoaded(true);
        });
    };

    const submitForm = (event) => {
        event.preventDefault();

        generalStore.submitForm();
    };

    return {
        getFieldValue,
        setupForm,
        submitForm,
    };
}
