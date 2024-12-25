// globals.d.ts or vue-shims.d.ts
import "vue";
import User from "./types/User";

declare module "@vue/runtime-core" {
    interface ComponentCustomProperties {
        route: (
            name: string,
            params?: string | any,
            absolute?: boolean,
            config?: Record<string, unknown>
        ) => string;
    }

    // can permission helper
    interface ComponentCustomProperties {
        can: (permission: string) => boolean;
    }
}

declare global {
    const route: (
        name: string,
        params?: string | any,
        absolute?: boolean,
        config?: Record<string, unknown>
    ) => string;
}

export {};
