import { Dictionary } from './dictionary';

export interface ChoiceCard {
    title: string;
    list: Dictionary<string, string>[];
    hideBack?: boolean;
    iconColors?: string[];
}
