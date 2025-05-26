import { get } from "lodash";
import { useGeneralStore } from "@/store/general";
import { ref } from "vue";

export function useForm() {
    const generalStore = useGeneralStore();

    // find value by dotted path
    const getFieldValue = (path) => ref(get(generalStore.data, path));

    return {
        getFieldValue,
    };
}
