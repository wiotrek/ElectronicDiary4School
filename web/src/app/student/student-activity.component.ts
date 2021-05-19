import { Component } from '@angular/core';
import { StudentUniversal } from 'src/app/_models/_student/student-universal';
import { Subjects } from 'src/app/_models/_student/subjects';
import { Card } from 'src/app/_models/_universal/card';

@Component({
  selector: 'app-student-activity',
  template: `
  <app-student-universal-list [dateFromParent]="toUniversal"></app-student-universal-list>`
})
export class StudentActivityComponent {
  toUniversal = {} as StudentUniversal;
  secondNav = {  title: 'Frekwencja' };
  toHeader: Card[];
  list: Subjects[];
  themeColor = '#87CEFA';

  constructor() {
    this.toHeader = this.fillHeader();
    this.list = this.fillList();
    this.toUniversal = {
      nav: this.secondNav,
      header: this.toHeader.reduce((total: Card[], curr: Card): Card[] => {
        curr.color = this.themeColor;
        total.push(curr);
        return total; }, []),
      mainList: this.list,
      color: this.themeColor
    };
   }


  fillList = (): Subjects[] => [
    {
      details: {
        name: 'Matematyka',
        icon: 'bi bi-patch-question',
        avg: '96%',
        position: 3,
        countAbandoned: 3,
      },
      days: [
        '2021-05-21',
        '2021-04-21',
        '2021-03-21'
      ]
    },
    {
      details: {
        name: 'Matematyka',
        icon: 'bi bi-patch-question',
        avg: '96%',
        position: 3,
        countAbandoned: 3,
      },
      days: [
        '2021-05-21',
        '2021-04-21',
        '2021-03-21'
      ]
    },
    {
      details: {
        name: 'Matematyka',
        icon: 'bi bi-patch-question',
        avg: '96%',
        position: 3,
        countAbandoned: 3,
      },
      days: [
        '2021-05-21',
        '2021-04-21',
        '2021-03-21'
      ]
    }
  ]


  fillHeader = (): Card[] => [
    {
      caption: '89%',
      name: 'Twoja Frekwencja',
      readonly: true,
      listViewOff: true
    },
    {
      caption: '5',
      name: 'Twoja pozycja w klasie',
      readonly: true,
      listViewOff: true
    }
  ]

}
