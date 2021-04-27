import { MarkItem } from './mark-item';
import { StudentPresentList } from './student-present-list';

export interface StudentMark {
    student: StudentPresentList;
    mark: MarkItem[];
}
