export interface ReadMessage {
    id: number;
    avatar: string;
    fullName: string;
    dateTime: string;
    kindOf: string;
    isSender: boolean;
    isReaded: boolean;
    subject: string;
    message: string;
    identifier: string;
}
