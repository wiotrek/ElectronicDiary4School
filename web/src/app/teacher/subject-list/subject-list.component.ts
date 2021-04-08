import { Component } from '@angular/core';
import { TeacherChoiceCard } from 'src/app/_models/teacher-choice-card';

@Component({
  selector: 'app-subject-list',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class SubjectListComponent{

  dateToChild = {} as TeacherChoiceCard;

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
