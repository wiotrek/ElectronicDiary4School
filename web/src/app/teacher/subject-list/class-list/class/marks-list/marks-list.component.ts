import { Component, OnInit } from '@angular/core';
import { StudentMark } from 'src/app/_models/models_teacher/student-mark';

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
  list: StudentMark[] = [
    {
      student: {
      identifier: '1233',
      first_name: 'Jan',
      last_name: 'Kowlaski'
      },
      mark: [
        {
          mark: '3',
          topic: 'Mnozenie i dzielenie',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '5',
          topic: 'Dodawanie i odejmowanie',
          kindOf: 'Kartkówka'
        }
      ]
    },
    {
      student: {
      identifier: '1233',
      first_name: 'Jan',
      last_name: 'Kowlaski'
      },
      mark: [
        {
          mark: '3',
          topic: 'Mnozenie i dzielenie',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '5',
          topic: 'Dodawanie i odejmowanie',
          kindOf: 'Kartkówka'
        }
      ]
    },
    {
      student: {
      identifier: '1233',
      first_name: 'Jan',
      last_name: 'Kowlaski'
      },
      mark: [
        {
          mark: '3',
          topic: 'Mnozenie i dzielenie',
          kindOf: 'Sprawdzian'
        },
        {
          mark: '5',
          topic: 'Dodawanie i odejmowanie',
          kindOf: 'Kartkówka'
        }
      ]
    }
  ];

  constructor() { }

  ngOnInit(): void {
  }

  editModeToggle(ind: number): void {
    this.editModeForIndex === ind
    ? this.editModeForIndex = -1
    : this.editModeForIndex = ind;
  }

}
