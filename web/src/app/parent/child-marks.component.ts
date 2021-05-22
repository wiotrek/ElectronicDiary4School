import { Component, OnInit } from '@angular/core';
import { StudentUniversal } from '../_models/_student/student-universal';
import { Subjects } from '../_models/_student/subjects';
import { Card } from '../_models/_universal/card';

@Component({
  selector: 'app-child-marks',
  template: `
  <app-student-universal-list [dateFromParent]="toUniversal"></app-student-universal-list>`
})
export class ChildMarksComponent implements OnInit {
  toUniversal = {} as StudentUniversal;
  themeColor = '#F4A460';

  ngOnInit(): void {
    this.toUniversal.color = this.themeColor;
    this.toUniversal.nav = {  title: 'Oceny ucznia' };

    this.toUniversal.header = this.fillHeader();
    this.toUniversal.mainList = this.fillMainList();
  }

  fillHeader = (): Card[] => [
    {
      caption: '3.21',
      name: 'Średnia dziecka',
      readonly: true,
      listViewOff: true,
      color: this.themeColor
    },
    {
      caption: '2',
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
        avg: '2.21',
        position: 2
      },
      marks: [
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        }
      ]
    },
    {
      subject: {
        name: 'Matematyka',
        avg: '2.21',
        position: 2
      },
      marks: [
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        }
      ]
    },
    {
      subject: {
        name: 'Matematyka',
        avg: '2.21',
        position: 2
      },
      marks: [
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '4',
          topic: 'Dodawanie i odejmowanie',
          date: '2021-04-21',
          kindOf: 'Sprawdzian'
        }
      ]
    }
  ]




}
