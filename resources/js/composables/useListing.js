import { useGeneralStore } from "@/store/general";
import { debounce, clearFields } from "@/helpers";

export function useListing() {
    const generalStore = useGeneralStore();

    const deleteRow = (id) => {
        if (window.confirm("Naozaj si želáš odstrániť položku?")) {
            generalStore.deleteSingle(id).then(() => generalStore.fetchAll());
        }
    };

    const changePage = (page) => {
        generalStore.page = page;

        generalStore.fetchAll();
    };

    const changeFilterField = debounce(() => {
        generalStore.fetchFilter();
    });

    const resetFilter = () => {
        clearFields("filter");

        generalStore.fetchAll();
    };

    // load form builder and model (if edit)
    const setupListing = (props) => {
        generalStore.setModel(props.model);

        generalStore.fetchListingBuilder().then(async () => {
            await generalStore.fetchAll();

            generalStore.setLoaded(true);
        });
    };

    return {
        deleteRow,
        resetFilter,
        changePage,
        setupListing,
        changeFilterField,
    };
}
