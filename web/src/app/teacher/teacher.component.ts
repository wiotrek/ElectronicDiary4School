import { Component } from '@angular/core';
import { ChoiceCard } from '../_models/choice-card';

@Component({
  selector: 'app-teacher',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class TeacherComponent {

  dateToChild = {} as ChoiceCard;

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
