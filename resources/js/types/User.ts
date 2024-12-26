import Role from "./Role";

export default interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    profile_photo_path: string;
    profile_photo_url: string;
    created_at: string;
    updated_at: string;

    roles: Role[];
    notifications?: any[];
}
