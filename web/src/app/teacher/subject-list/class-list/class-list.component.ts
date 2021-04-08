import { Component } from '@angular/core';
import { TeacherChoiceCard } from 'src/app/_models/teacher-choice-card';

@Component({
  selector: 'app-class-list',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class ClassListComponent {

  dateToChild = {} as TeacherChoiceCard;

  list = [
    'Klasa 3D',
    'Klasa 4B',
    'Klasa 5C'
  ];

  constructor() {
    this.dateToChild.title = 'Wybierz przedmiot';
    this.dateToChild.list = this.list;
  }
}
