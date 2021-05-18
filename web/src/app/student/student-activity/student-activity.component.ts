import { Component, OnInit } from '@angular/core';
import { Card } from 'src/app/_models/_universal/card';

@Component({
  selector: 'app-student-activity',
  templateUrl: './student-activity.component.html',
  styleUrls: ['./student-activity.component.css']
})
export class StudentActivityComponent implements OnInit {
  toChild = {  title: 'Frekwencja' };
  toHeader: Card[];
  list: any;

  constructor() {
    this.toHeader = this.fillHeader();
    this.list = this.fillList();
   }

  ngOnInit(): void {
  }

  fillList = () => [
    {
      name: 'Matematyka',
      icon: 'bi bi-patch-question',
      avg: '96%',
      position: 3,
      abandoned: 3
    }
  ]


  fillHeader = (): Card[] => [
    {
      caption: '89%',
      color: '#87CEFA',
      name: 'Twoja Frekwencja',
      readonly: true,
      listViewOff: true
    },
    {
      caption: '5',
      color: '#87CEFA',
      name: 'Twoja pozycja w klasie',
      readonly: true,
      listViewOff: true
    }
  ]

}
