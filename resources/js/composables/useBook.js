import { useGeneralStore } from "@/store/general";
import { useBookStore } from "@/store/book";

export function useBook() {
    const generalStore = useGeneralStore();

    const bookStore = useBookStore();

    const borrowBook = (id) => {
        bookStore.borrow(id).then(() => generalStore.fetchAll());
    };

    return {
        borrowBook,
    };
}
