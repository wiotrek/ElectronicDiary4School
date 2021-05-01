import { Component, Input, OnInit } from '@angular/core';
import { Marks } from 'src/app/_models/models_teacher/marks';

@Component({
  selector: 'app-edit-marks',
  templateUrl: './edit-marks.component.html',
  styleUrls: ['./edit-marks.component.css']
})
export class EditMarksComponent implements OnInit {
  @Input() getMarks = {} as Marks[];

  constructor() { }

  ngOnInit(): void {}
}
