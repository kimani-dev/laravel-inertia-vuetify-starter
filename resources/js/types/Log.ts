import User from "./User";

export default interface Log {
    id: number;
    user_id: number;
    user: User;
    action: string;
    ip_address: string;
    resource: string;
    created_at: string;
}
