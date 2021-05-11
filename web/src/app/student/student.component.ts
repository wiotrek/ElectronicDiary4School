import { Component } from '@angular/core';
import { DateToChoiceCard } from '../_models/date-to-choice-card';
import { ListToCard } from '../_models/list-to-card';

@Component({
  selector: 'app-student',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class StudentComponent {

  dateToChild: DateToChoiceCard;

  // static list
  list: ListToCard[] = [
    { name: 'Sprawdź oceny', icon: 'bi bi-graph-up' },
    { name: 'Zobacz frekwencje', icon: 'bi bi-check2-square' }
  ];

  // colors for icons
  colors = ['#F4A460'];

  constructor()
  { this.dateToChild = {
      title: 'Strona Główna',
      list: this.list,
      lackResource: 'kart',
      hideBack: true,
      iconColors: this.colors
    }; }
}
