import { Component } from '@angular/core';
import { TeacherChoiceCard } from '../_models/teacher-choice-card';

@Component({
  selector: 'app-teacher',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class TeacherComponent {

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
}
