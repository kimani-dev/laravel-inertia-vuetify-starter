import "vuetify/styles";
import "@mdi/font/css/materialdesignicons.css";
import { aliases, mdi } from "vuetify/iconsets/mdi";
import { createVuetify } from "vuetify";

export default createVuetify({
    // Default set is MDI
    icons: {
        aliases,
        sets: {
            mdi,
        },
    },
    //Setup default theme and other themes as well as specify colors
    theme: {
        defaultTheme: "light",
        themes: {
            light: {
                colors: {
                    primary: "#6c63ff",
                    background: "#f3f4f6",
                },
            },
        },
    },
    // Setup defaults for components globaly
    defaults: {
        VBtn: { color: "primary", class: "text-capitalize" },
        VTextField: { variant: "outlined", rounded: "lg", color: "primary" },
        VCard: { rounded: "lg" },
        VCheckbox: { color: "primary" },
    },
});
