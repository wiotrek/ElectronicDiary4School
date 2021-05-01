import { Marks } from './marks';
import { Student } from './student';

export interface StudentsMarks {
    student: Student;
    marks: Marks[];
}
