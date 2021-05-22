import { Component, OnInit } from '@angular/core';
import { StudentUniversal } from '../_models/_student/student-universal';
import { Subjects } from '../_models/_student/subjects';
import { Card } from '../_models/_universal/card';

@Component({
  selector: 'app-child-activity',
  template: `
  <app-student-universal-list [dateFromParent]="toUniversal"></app-student-universal-list>`
})
export class ChildActivityComponent implements OnInit {
  toUniversal = {} as StudentUniversal;
  themeColor = '#87CEFA';

  ngOnInit(): void {
    this.toUniversal.color = this.themeColor;
    this.toUniversal.nav = {  title: 'Frekwencja ucznia' };

    this.toUniversal.header = this.fillHeader();
    this.toUniversal.mainList = this.fillMainList();
  }

  fillHeader = (): Card[] => [
    {
      caption: '98%',
      name: 'Frekwencja dziecka',
      readonly: true,
      listViewOff: true,
      color: this.themeColor
    },
    {
      caption: '3',
      name: 'Pozycja na tle innych dzieci',
      readonly: true,
      listViewOff: true,
      color: this.themeColor
    }
  ]

  fillMainList = (): Subjects[] => [
    {
      subject: {
        name: 'Matematyka',
        avg: '90%',
        position: 2,
        countAbandoned: 3
      },
      days: [
        '2021-04-21',
        '2021-04-21',
        '2021-04-21',
      ]
    },
    {
      subject: {
        name: 'Matematyka',
        avg: '90%',
        position: 2,
        countAbandoned: 3
      },
      days: [
        '2021-04-21',
        '2021-04-21',
        '2021-04-21',
      ]
    },
    {
      subject: {
        name: 'Matematyka',
        avg: '90%',
        position: 2,
        countAbandoned: 3
      },
      days: [
        '2021-04-21',
        '2021-04-21',
        '2021-04-21',
      ]
    }
  ]

}
