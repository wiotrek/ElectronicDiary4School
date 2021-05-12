import { Card } from './_universal/card';

export interface DateToChoiceCard {
    title: string;
    list: Card[];
    lackResource: string;
    hideBack?: boolean;
    iconColors?: string[];
}
