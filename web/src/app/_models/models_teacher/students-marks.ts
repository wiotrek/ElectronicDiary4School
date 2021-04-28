import { MarkItem } from './mark-item';
import { StudentPresentList } from './student-present-list';

export interface StudentsMarks {
    student: StudentPresentList;
    marks: MarkItem[];
}
