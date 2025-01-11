import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Modal, ModalLink, renderApp } from "@inertiaui/modal-vue";

import "./echo.js";

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: renderApp(App, props) })
            .use(plugin)
            .component("Modal", Modal)
            .component("ModalLink", ModalLink)
            .component("Link", Link)
            .mount(el);
    },
});
