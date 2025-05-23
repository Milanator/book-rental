import { createApp } from "vue";
import axios from "axios";
import vuetify from "./plugins/vuetify";
import Pages from "./views";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const root = document.querySelector("#app");

const app = createApp(Pages[root.dataset.component], {
    ...JSON.parse(root.dataset.props),
});

app.use(vuetify).mount("#app");
