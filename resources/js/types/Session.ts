export default interface Session {
    id: number;
    user_id: number;
    ip_address: string;
    agent: {
        is_desktop: boolean;
        platform: string;
        browser: string;
    };
    is_current_device: boolean;
    payload: string;
    last_active: string;
}
