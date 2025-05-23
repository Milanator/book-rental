import { createApp } from "vue";
import { createPinia } from "pinia";
import Views from "@/views";

const root = document.querySelector("#app");

const pinia = createPinia();

const app = createApp(Views[root.dataset.component], {
    ...JSON.parse(root.dataset.props),
});

app.use(pinia).mount("#app");
