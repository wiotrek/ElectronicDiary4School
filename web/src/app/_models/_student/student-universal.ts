import { Card } from '../_universal/card';
import { Subjects } from './subjects';

export interface StudentUniversal {
    nav: any;
    header: Card[];
    mainList: Subjects[];
    color: string;
}
