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
  list: Subjects[];
  themeColor = '#F4A460';

  constructor(private studentService: StudentService) {
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

  ngOnInit(): void {
  }


  fillHeader = (): Card[] => [
    {
      caption: '4.21',
      name: 'Twoja średnia',
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

  fillList = (): Subjects[] => [
    {
      details: {
        name: 'Matematyka',
        avg: '4,21',
        position: 3
      },
      marks: [
        {
          mark: '4',
          topic: 'Mnożenie i dasd asd asd dzielenie',
          date: '2021-04-12',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Mnożenie i dzielenie',
          date: '2021-04-12',
          kindOf: 'Kartkówka'
        },
        {
          mark: '4',
          topic: 'Mnożenie i dzielenie',
          date: '2021-04-12',
          kindOf: 'Sprawdzian'
        }
      ]
    },
    {
      details: {
        name: 'Matematyka',
        icon: 'bi bi-alarm',
        avg: '4,21',
        position: 3
      },
      marks: [
        {
          mark: '4',
          topic: 'Mnożenie i dzielenie',
          date: '2021-04-12',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Mnożenie i dzielenie',
          date: '2021-04-12',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Mnożenie i dzielenie',
          date: '2021-04-12',
          kindOf: 'Sprawdzian'
        }
      ]
    },
    {
      details: {
        name: 'Matematyka',
        icon: 'bi bi-alarm',
        avg: '4,21',
        position: 3
      },
      marks: [
        {
          mark: '4',
          topic: 'Mnożenie i dzielenie',
          date: '2021-04-12',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Mnożenie i dzielenie',
          date: '2021-04-12',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Mnożenie i dzielenie',
          date: '2021-04-12',
          kindOf: 'Sprawdzian'
        }
      ]
    }
  ]




}
