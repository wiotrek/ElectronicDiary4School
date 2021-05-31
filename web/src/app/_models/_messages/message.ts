export interface Message {
    kindOf: string;
    content: string;
    sender?: string;
    receiver: string;
}
