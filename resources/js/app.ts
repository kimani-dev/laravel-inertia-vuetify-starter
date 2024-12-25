import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/src/js";
import { router } from "@inertiajs/vue3";
import vuetify from "./plugins/vuetify";

//@ts-ignore
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            //@ts-ignore
            import.meta.glob("./Pages/**/*.vue")
        ),
    //@ts-ignore
    setup({ el, App, props, plugin }) {
        return (
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue)
                .use(vuetify)
                // When used will make the element with the href property
                // navigate with inertia's route visit method hence maintaining
                // SPA behaviour instead of full page reload
                .directive("use-inertia-link", {
                    mounted(el) {
                        if (el.hasAttribute("href")) {
                            el.addEventListener("click", (e: Event) => {
                                e.preventDefault();
                                router.visit(el.getAttribute("href"));
                            });
                        }
                    },
                })
                .mount(el)
        );
    },

    progress: {
        color: "#4B5563",
    },
});
