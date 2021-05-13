import { StudentActivity } from './student-activity';

export interface StudentActivityObj {
  readOnly: boolean;
  date: string;
  StudentActivity: StudentActivity[];
}
