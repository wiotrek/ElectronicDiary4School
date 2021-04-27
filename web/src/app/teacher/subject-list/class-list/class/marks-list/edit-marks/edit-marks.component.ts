import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-edit-marks',
  templateUrl: './edit-marks.component.html',
  styleUrls: ['./edit-marks.component.css']
})
export class EditMarksComponent implements OnInit {
  list = [
    {marks: 2, kindOf: 'Sprawdzian'},
    {marks: 3, kindOf: 'Kartkówka'},
    {marks: 5, kindOf: 'Odpowiedź ustna'},
  ];

  constructor() { }

  ngOnInit(): void {
  }

}
