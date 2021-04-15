import { Component } from '@angular/core';
import { ChoiceCard } from 'src/app/_models/choice-card';
import { Dictionary } from 'src/app/_models/dictionary';

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

  list: Dictionary<string, string>[] = [
    { key: 'Klasa 4C', value: 'bi bi-suit-club' },
    { key: 'Klasa 6D', value: 'bi bi-suit-diamond' },
    { key: 'Klasa 7A', value: 'bi bi-suit-spade' },
  ];

  constructor()
  { this.dateToChild = {
      title: 'Wybierz klase',
      list: this.list
    }; }
}
