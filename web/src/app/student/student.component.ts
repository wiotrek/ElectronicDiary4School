import { Component } from '@angular/core';
import { DateToChoiceCard } from '../_models/_universal/date-to-choice-card';
import { Card } from '../_models/_universal/card';

@Component({
  selector: 'app-student',
  template: `<app-choice-card [dateFromParent]="dateToChild"></app-choice-card>`
})
export class StudentComponent {
  dateToChild: DateToChoiceCard;

  // static list
  list: Card[] = [
    { name: 'Sprawdź oceny', icon: 'bi bi-graph-up' },
    { name: 'Zobacz frekwencje', icon: 'bi bi-check2-square' }
  ];

  // colors for icons
  colors = ['#66CDAA'];

  constructor()
  { this.dateToChild = {
      title: 'Strona Główna',
      list: this.list,
      lackResource: 'kart',
      hideBack: true,
      iconColors: this.colors
    }; }
}
