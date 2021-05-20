import { Marks } from './marks/marks';
import { SubjectDetails } from './subject-details';

export interface Subjects {
    subject: SubjectDetails;
    marks?: Marks[];
    days?: string[];
}
