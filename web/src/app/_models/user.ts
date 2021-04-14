export interface User {
    message: {
        user_id: number;
        first_name: string;
        last_name: string;
        identifier: string;
    };
    role: string;
    profileUrl: string;
}
