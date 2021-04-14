import { Component } from '@angular/core';
import { ChoiceCard } from 'src/app/_models/choice-card';

@Component({
  selector: 'app-class-list',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class ClassListComponent {

  dateToChild = {} as ChoiceCard;

  list = [
    'Klasa 3D',
    'Klasa 4B',
    'Klasa 5C'
  ];

  constructor() {
    this.dateToChild.title = 'Wybierz klase';
    this.dateToChild.list = this.list;
  }
}
