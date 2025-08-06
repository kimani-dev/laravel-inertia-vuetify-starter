import Permission from "@/types/Permission";
import { usePage } from "@inertiajs/vue3";

export const Can = {
    install: (v: any) => {
        const page: any = usePage();

        const can = (permission: string) => {
            return page.props.auth.user.permissions.some(
                (p: Permission) => p.name === permission
            );
        };

        v.mixin({
            methods: { can },
        });
    },
};