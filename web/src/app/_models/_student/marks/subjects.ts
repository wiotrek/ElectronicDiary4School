import { Marks } from './marks';
import { SubjectDetails } from './subject-details';

export interface Subjects {
    details: SubjectDetails;
    marks: Marks[];
}
