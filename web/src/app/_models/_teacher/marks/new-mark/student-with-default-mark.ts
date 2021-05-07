import { Student } from '../../student';

export interface StudentWithDefaultMark {
  student: Student;
  select: boolean;
  mark: number;
}
