import { Component, Input, Output, EventEmitter, OnInit } from '@angular/core';
import { ToastrService } from 'ngx-toastr';
import { Marks } from 'src/app/_models/_teacher/marks/marks';
import { UpdateMark } from 'src/app/_models/_teacher/marks/update-marks/update-mark';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-edit-marks',
  templateUrl: './edit-marks.component.html',
  styleUrls: ['./edit-marks.component.css']
})
export class EditMarksComponent implements OnInit{
  @Input() getMarksJson: any;
  @Output() refreshList = new EventEmitter();
  getMarks: Marks[] = [];

  constructor(
    private teacherService: TeacherService,
    private toastr: ToastrService) { }

  ngOnInit(): void {
    this.getMarks = JSON.parse(this.getMarksJson);
  }

  update(): void {
    const updatedMarks = this.getMarks.reduce((result: UpdateMark[], current: Marks): UpdateMark[] => {
      result.push({student_marks_id: current.student_marks_id, mark: current.mark.toString()});
      return result;
    }, []);

    this.teacherService.updateStudentMarks(updatedMarks).subscribe(
      () => {
        this.toastr.success('Ocena została zmieniona');
        this.refreshList.emit(true);
      }, () => this.toastr.error('Nie udało się zaktualizować'));
  }
}
