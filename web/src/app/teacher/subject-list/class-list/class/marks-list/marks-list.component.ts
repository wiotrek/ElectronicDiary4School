import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { StudentsMarks } from 'src/app/_models/models_teacher/students-marks';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-marks-list',
  templateUrl: './marks-list.component.html',
  styleUrls: ['./marks-list.component.css']
})
export class MarksListComponent implements OnInit {
  toChild = {
    title: 'Oceny'
  };
  editModeForIndex = -1;
  list: StudentsMarks[] = [];

  constructor(
    private teacherService: TeacherService,
    private route: ActivatedRoute
    ) { }

  ngOnInit(): void {
    this.getStudentsMarks();
  }

  getStudentsMarks(): void {
    const className = this.route.snapshot.paramMap.get('class') || '';

    const subject = this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || '');

    this.teacherService.getStudentsMarks(className, subject).subscribe(
      (res: StudentsMarks[]) => this.list = res,
      (err: any) => console.log(err));
  }

  editModeToggle(ind: number): void {
    this.editModeForIndex === ind
    ? this.editModeForIndex = -1
    : this.editModeForIndex = ind;
  }

}
