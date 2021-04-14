import { Component } from '@angular/core';
import { ChoiceCard } from 'src/app/_models/choice-card';

@Component({
  selector: 'app-subject-list',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class SubjectListComponent{

  dateToChild = {} as ChoiceCard;

  list = [
    'polski',
    'muzyka',
    'informatyka',
    'przyroda',
    'joga',
    'wf',
    'hiszpanski',
    'chemia',
    'fizyka'
  ];

  constructor() {
    this.dateToChild.title = 'Wybierz przedmiot';
    this.dateToChild.list = this.list;
  }
}
