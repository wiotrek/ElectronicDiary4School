import { Component, Input } from '@angular/core';
import { StudentUniversal } from 'src/app/_models/_student/student-universal';

@Component({
  selector: 'app-student-universal-list',
  templateUrl: './student-universal-list.component.html',
  styleUrls: ['./student-universal-list.component.css']
})
export class StudentUniversalListComponent {
  @Input() dateFromParent = {} as StudentUniversal;
  editModeForIndex = -1;

  editModeToggle(ind: number): void {
    this.editModeForIndex === ind
    ? this.editModeForIndex = -1
    : this.editModeForIndex = ind;
  }
}
