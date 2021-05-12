import { Component, OnInit } from '@angular/core';
import { Card } from 'src/app/_models/_universal/card';

@Component({
  selector: 'app-student-marks',
  templateUrl: './student-marks.component.html',
  styleUrls: ['./student-marks.component.css']
})
export class StudentMarksComponent implements OnInit {
  toChild = {  title: 'Twoje oceny' };
  toHeader: Card[];

  constructor() {
    this.toHeader = this.fillHeader();
   }

  ngOnInit(): void {
  }

  fillHeader = () => [
    {
      caption: '75%',
      color: '#7FFFD4',
      name: 'Twoja frekwencja',
      readonly: true
    },
    {
      caption: '4.21',
      color: '#7FFFD4',
      name: 'Twoja średnia',
      readonly: true
    }
  ]

}
