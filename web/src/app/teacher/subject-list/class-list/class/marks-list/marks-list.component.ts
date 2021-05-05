import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Marks } from 'src/app/_models/_teacher/marks/marks';
import { StudentsMarks } from 'src/app/_models/_teacher/marks/students-marks';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-marks-list',
  templateUrl: './marks-list.component.html',
  styleUrls: ['./marks-list.component.css']
})
export class MarksListComponent implements OnInit {
  toChild = { title: 'Oceny' };
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

    // tslint:disable-next-line: deprecation
    this.teacherService.getStudentsMarks(subject, className).subscribe(
      (res: StudentsMarks[]) => this.list = res,
      (err: any) => console.log(err));

  }

  // opening card to edit mark
  editModeToggle(ind: number): void {
    this.editModeForIndex === ind
    ? this.editModeForIndex = -1
    : this.editModeForIndex = ind;
  }

  // only way to copping array
  sendJsonMarks(marks: Marks[]): string {
    return JSON.stringify(marks);
  }
}
