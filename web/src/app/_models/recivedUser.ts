export interface RecivedUser {
    message: {
        first_name: string;
        last_name: string;
        identifier: string;
    };
    role: [
        {
            status: string;
        }
    ];
}
