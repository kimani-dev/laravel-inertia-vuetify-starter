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
            class: "text-capitalize font-weight-bold",
            VIcon: { color: "white" },
            size: "small",
            rounded: "lg",
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
