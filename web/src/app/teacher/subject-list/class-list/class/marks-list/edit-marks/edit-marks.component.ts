import { Component, Input, Output, EventEmitter } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { Marks } from 'src/app/_models/models_teacher/marks';
import { UpdateMark } from 'src/app/_models/models_teacher/update-mark';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-edit-marks',
  templateUrl: './edit-marks.component.html',
  styleUrls: ['./edit-marks.component.css']
})
export class EditMarksComponent {
  @Input() getMarks: Marks[] = [];
  // @Output() getMarksUpdate = new EventEmitter<Marks[]>();
  @Output() closeEditMode = new EventEmitter();

  constructor(
    private teacherService: TeacherService,
    private toastr: ToastrService) { }

  update(): void {
    const updatedMarks = this.getMarks.reduce((result: UpdateMark[], current: Marks): UpdateMark[] => {
      result.push({student_marks_id: current.student_marks_id, mark: current.mark.toString()});
      return result;
    }, []);

    this.teacherService.updateStudentMarks(updatedMarks).subscribe(
      () => {
        this.toastr.success('Ocena została zmieniona');
        this.closeEditMode.emit(-1);
      },
      () => {
        this.toastr.error('Nie udało się zaktualizować');
        this.closeEditMode.emit(-1);
      },
      () => console.log('dupa'));
  }
}
