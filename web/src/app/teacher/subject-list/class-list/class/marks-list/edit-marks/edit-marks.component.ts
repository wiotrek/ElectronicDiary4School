import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-edit-marks',
  templateUrl: './edit-marks.component.html',
  styleUrls: ['./edit-marks.component.css']
})
export class EditMarksComponent implements OnInit {
  list = [
    {marks: 2, topic: 'Tworzenie oprogramowania dsad asd asd asd asdasd asdasd asd', kindOf: 'Sprawdzian'},
    {marks: 3, topic: 'kurs kulinarny z moodle', kindOf: 'Kartkówka'},
    {marks: 2, topic: 'Tworzenie oprogramowania dsad asd asd asd asdasd asdasd asd', kindOf: 'Sprawdzian'},
    {marks: 5, topic: 'sprawdzenie wiedzy', kindOf: 'Odpowiedź ustna'},
  ];

  constructor() { }

  ngOnInit(): void {
  }

}
