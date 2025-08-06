import "vuetify/styles";
import "@mdi/font/css/materialdesignicons.css";
import { aliases, mdi } from "vuetify/iconsets/mdi";
import { createVuetify } from "vuetify";

const FormFieldDefaults = {
    density: "comfortable",
    rounded: "lg",
    variant: "outlined",
    color: "primary",
};

export default createVuetify({
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
                    primary: "#a855f7",
                    background: "#f4f5f7",
                },
            },
            dark: {
                colors: {
                    primary: "#ec4899",
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
            rounded: "md",
        },
        VCard: { rounded: "lg" },
        // form items
        VCheckbox: { color: "primary" },
        VTextField: { ...FormFieldDefaults },
        VSelect: { ...FormFieldDefaults },
        VTextarea: { ...FormFieldDefaults },
        VSlider: { color: "primary" },
        VFileInput: { ...FormFieldDefaults },

        VContainer: { class: "pa-1 pa-md-0" },
        VIcon: { color: "primary" },
        VChip: {
            rounded: "lg",
            class: "font-weight-bold",
        },
        VDateInput: { VBtn: { VIcon: { color: "primary" } } },
    },
});
