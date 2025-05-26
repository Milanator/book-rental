import { useGeneralStore } from "@/store/general";

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

    return {
        deleteRow,
        changePage,
    };
}
