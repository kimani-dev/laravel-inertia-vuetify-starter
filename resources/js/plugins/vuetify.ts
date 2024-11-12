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
        defaultTheme: localStorage.getItem("theme") || "light",
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
        VBtn: {
            color: "primary",
            class: "text-capitalize",
            VIcon: { color: "white" },
            size: "small",
        },
        VCard: { rounded: "lg" },
        // form items
        VCheckbox: { color: "primary" },
        VTextField: { variant: "outlined", rounded: "lg", color: "primary" },
        VSelect: { variant: "outlined", rounded: "lg", color: "primary" },
        VTextarea: { variant: "outlined", rounded: "lg", color: "primary" },
        VSlider: { color: "primary" },
        VFileInput: { color: "primary", rounded: "lg", variant: "outlined" },
        //container
        VContainer: { class: "pa-1 pa-md-0" },
        // icons
        VIcon: { color: "primary" },
        // chip
        VChip: {
            rounded: "lg",
            class: "font-weight-bold",
        },
    },
});
