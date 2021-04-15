import { Component } from '@angular/core';
import { ChoiceCard } from 'src/app/_models/choice-card';
import { Dictionary } from 'src/app/_models/dictionary';

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

  list: Dictionary<string, string>[] = [
    { key: 'Wychowanie do życia w rodzinie', value: 'fa fa-paint-brush' },
    { key: 'Muzyka', value: 'bi bi-joystick' },
    { key: 'Polski', value: 'fa fa-etsy' },
    { key: 'Matematyka', value: 'bi bi-graph-up' },
    { key: 'Plastyka', value: 'fa fa-paint-brush' }
  ];

  constructor()
  { this.dateToChild = {
      title: 'Wybierz przedmiot',
      list: this.list
    }; }
}
