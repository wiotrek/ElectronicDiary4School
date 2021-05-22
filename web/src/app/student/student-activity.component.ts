import { Component, OnInit } from '@angular/core';
import { StudentUniversal } from 'src/app/_models/_student/student-universal';
import { Subjects } from 'src/app/_models/_student/subjects';
import { Card } from 'src/app/_models/_universal/card';
import { StudentService } from '../_services/student.service';

@Component({
  selector: 'app-student-activity',
  template: `
  <app-student-universal-list [dateFromParent]="toUniversal"></app-student-universal-list>`
})
export class StudentActivityComponent implements OnInit {
  toUniversal = {} as StudentUniversal;
  themeColor = '#87CEFA';

  constructor(private studentService: StudentService) {}

  ngOnInit(): void {
    this.toUniversal.color = this.themeColor;
    this.toUniversal.nav = {  title: 'Frekwencja' };

    this.studentService.getAvgSubjectFrequencies()
    .subscribe((res: Card[]) => {
      this.toUniversal.header = res
        .reduce((total: Card[], curr: Card): Card[] => {
          curr.color = this.themeColor;
          curr.readonly = true;
          curr.listViewOff = true;
          total.push(curr);
          return total; }, []);
      });

    this.studentService.getFrequencies()
      .subscribe((res: Subjects[]) => this.toUniversal.mainList = res);
  }
}
