import { Component } from '@angular/core';
import { DateToChoiceCard } from '../_models/date-to-choice-card';
import { ListToCard } from '../_models/list-to-card';

@Component({
  selector: 'app-teacher',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class TeacherComponent {
  dateToChild = {} as DateToChoiceCard;

  // static list
  list: ListToCard[] = [
    { name: 'Rozpocznij lekcje', icon: 'bi bi-subtract' },
    { name: 'Powiadomienia', icon: 'bi bi-chat-dots' }
  ];

  // colors for icons
  colors = [
    '#F4A460',
    '#7FFFD4'
  ];

  constructor()
  { this.dateToChild = {
      title: 'Strona Główna',
      list: this.list,
      lackResource: 'kart',
      hideBack: true,
      iconColors: this.colors
    }; }
}
