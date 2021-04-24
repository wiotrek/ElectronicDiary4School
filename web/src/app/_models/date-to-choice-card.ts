import { ListToCard } from './list-to-card';

export interface DateToChoiceCard {
    title: string;
    list: ListToCard[];
    lackResource: string;
    hideBack?: boolean;
    iconColors?: string[];
}
