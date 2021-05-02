import { Component, Input, OnInit } from '@angular/core';
import { Marks } from 'src/app/_models/models_teacher/marks';
import { UpdateMark } from 'src/app/_models/models_teacher/update-mark';

@Component({
  selector: 'app-edit-marks',
  templateUrl: './edit-marks.component.html',
  styleUrls: ['./edit-marks.component.css']
})
export class EditMarksComponent implements OnInit {
  @Input() getMarks: Marks[] = [];
  @Input() suppliesToupdate = {} as UpdateMark;

  constructor() { }

  ngOnInit(): void {}

  show(): void {
    const obj = {
      mark: this.getMarks,
      clas: this.suppliesToupdate.className,
      sub: this.suppliesToupdate.subjectName,
      id: this.suppliesToupdate.identifier
    };
    console.log(obj);
  }
}
