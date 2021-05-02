import { Component, Input } from '@angular/core';
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

  constructor(
    private teacherService: TeacherService,
    private toastr: ToastrService) { }

  update(): void {
    const updatedMarks = this.getMarks.reduce((result: UpdateMark[], current: Marks): UpdateMark[] => {
      result.push({student_marks_id: current.student_marks_id, mark: current.mark.toString()});
      return result;
    }, []);

    this.teacherService.updateStudentMarks(updatedMarks).subscribe(
      (res: any) => {
        this.toastr.success('Udało się');
        console.log(res);
      },
      (err: any) => {
        this.toastr.error('Nie udało sie');
        console.log(err);
      });
  }
}
