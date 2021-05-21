import { Component } from '@angular/core';
import { Card } from '../_models/_universal/card';
import { DateToChoiceCard } from '../_models/_universal/date-to-choice-card';

@Component({
  selector: 'app-parent',
  template: `<app-choice-card [dateFromParent]="dateToChild"></app-choice-card>`
})
export class ParentComponent {
  dateToChild: DateToChoiceCard;

  // static list
  list: Card[] = [
    { name: 'Sprawdź oceny', icon: 'bi bi-graph-up' },
    { name: 'Zobacz frekwencje', icon: 'bi bi-check2-square' },
    { name: 'Powiadomienia', icon: 'bi bi-chat-dots' },
  ];

  // colors for icons
  colors = ['#BA55D3', '#20B2AA', '#F4A460'];

  constructor()
  { this.dateToChild = {
      title: 'Strona Główna',
      list: this.list,
      lackResource: 'kart',
      hideBack: true,
      iconColors: this.colors
    }; }

}
