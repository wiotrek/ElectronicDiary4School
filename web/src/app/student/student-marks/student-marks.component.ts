import { Component, OnInit } from '@angular/core';
import { Subjects } from 'src/app/_models/_student/marks/subjects';
import { Card } from 'src/app/_models/_universal/card';
import { StudentService } from 'src/app/_services/student.service';

@Component({
  selector: 'app-student-marks',
  templateUrl: './student-marks.component.html',
  styleUrls: ['./student-marks.component.css']
})
export class StudentMarksComponent implements OnInit {
  editModeForIndex = -1;
  toChild = {  title: 'Twoje oceny' };
  toHeader: Card[];
  list: Subjects[];

  constructor(private studentService: StudentService) {
    this.toHeader = this.fillHeader();
    this.list = this.fillList();
   }

  ngOnInit(): void {
  }

  editModeToggle(ind: number): void {
    this.editModeForIndex === ind
    ? this.editModeForIndex = -1
    : this.editModeForIndex = ind;
  }

  fillHeader = (): Card[] => [
    {
      caption: '4.21',
      color: '#7FFFD4',
      name: 'Twoja średnia',
      readonly: true,
      listViewOff: true
    },
    {
      caption: '5',
      color: '#7FFFD4',
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
