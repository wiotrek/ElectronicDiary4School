import { Component, OnInit } from '@angular/core';
import { TeacherChoiceCard } from '../_models/teacher-choice-card';

@Component({
  selector: 'app-teacher',
  templateUrl: './teacher.component.html',
  styleUrls: ['./teacher.component.css']
})
export class TeacherComponent implements OnInit {

  dateToChild = {} as TeacherChoiceCard;

  list = [
    'Rozpocznij lekcje'
  ];

  constructor(
  ) {
    this.dateToChild.title = 'Strona Główna';
    this.dateToChild.action = 'wybrano';
    this.dateToChild.hideBack = true;
    this.dateToChild.list = this.list;
  }

  ngOnInit(): void {
  }

}
