import Permission from "./Permission";

export default interface Role {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;

    permissions: Permission[];
}
