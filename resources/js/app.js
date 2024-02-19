import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

import vuetify from "./plugins/vuetify";
import { router } from "@inertiajs/vue3";

//components
import MyDialog from "./Components/MyDialog.vue";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return (
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue)
                // vuetify
                .use(vuetify)
                // When used will make the element with the href property
                // navigate with inertia's route visit method hence maintaining
                // SPA behaviour instead of full page reload
                .directive("use-inertia-link", {
                    mounted(el) {
                        if (el.hasAttribute("href")) {
                            el.addEventListener("click", (e) => {
                                e.preventDefault();
                                router.visit(el.getAttribute("href"));
                            });
                        }
                    },
                })
                //components
                .component("my-dialog", MyDialog)
                .mount(el)
        );
    },
    progress: {
        color: "#4B5563",
    },
});
