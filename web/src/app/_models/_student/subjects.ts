import { Marks } from './marks/marks';
import { SubjectDetails } from './subject-details';

export interface Subjects {
    details: SubjectDetails;
    marks?: Marks[];
    days?: string[];
}
