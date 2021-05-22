import { Component, OnInit } from '@angular/core';
import { StudentUniversal } from 'src/app/_models/_student/student-universal';
import { Subjects } from 'src/app/_models/_student/subjects';
import { Card } from 'src/app/_models/_universal/card';
import { StudentService } from 'src/app/_services/student.service';

@Component({
  selector: 'app-student-marks',
  template: `
  <app-student-universal-list [dateFromParent]="toUniversal"></app-student-universal-list>`
})
export class StudentMarksComponent implements OnInit {
  toUniversal = {} as StudentUniversal;
  themeColor = '#F4A460';

  constructor(private studentService: StudentService) {}

  ngOnInit(): void {
    this.toUniversal.color = this.themeColor;
    this.toUniversal.nav = {  title: 'Oceny' };

    this.studentService.getAvgSubjectMarks()
        .subscribe((res: Card[]) => {
          this.toUniversal.header = res
          .reduce((total: Card[], curr: Card): Card[] => {
            curr.color = this.themeColor;
            curr.readonly = true;
            curr.listViewOff = true;
            total.push(curr);
            return total; }, []);
        });

    this.studentService.getSubjects()
      .subscribe((res: Subjects[]) => this.toUniversal.mainList = res);
  }
}
