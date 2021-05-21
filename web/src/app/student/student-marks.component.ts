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
  secondNav = {  title: 'Oceny' };
  toHeader: Card[];
  themeColor = '#F4A460';

  constructor(private studentService: StudentService) {
    this.toHeader = this.fillHeader();
   }

  ngOnInit(): void {
    this.toUniversal.color = this.themeColor;
    this.toUniversal.nav = this.secondNav;
    this.toUniversal.header = this.toHeader
      .reduce((total: Card[], curr: Card): Card[] => {
        curr.color = this.themeColor;
        curr.readonly = true;
        curr.listViewOff = true;
        total.push(curr);
        return total; }, []),

    this.studentService.getSubjects()
      .subscribe((res: Subjects[]) => this.toUniversal.mainList = res);
  }


  fillHeader = (): Card[] => [
    {
      caption: '4.21',
      name: 'Twoja średnia'
    },
    {
      caption: '5',
      name: 'Twoja pozycja w klasie'
    }
  ]
}
