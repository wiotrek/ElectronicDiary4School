import { Component } from '@angular/core';
import { DateToChoiceCard } from '../_models/date-to-choice-card';
import { Card } from '../_models/_universal/card';

@Component({
  selector: 'app-teacher',
  template: `<app-choice-card [dateFromParent]="dateToChild"></app-choice-card>`
})
export class TeacherComponent {
  dateToChild: DateToChoiceCard;

  // static list
  list: Card[] = [
    { description: 'Rozpocznij lekcje', icon: 'bi bi-subtract'},
    { description: 'Powiadomienia', icon: 'bi bi-chat-dots'}
  ];

  // colors for icons
  colors = ['#F4A460', '#7FFFD4'];

  constructor()
  { this.dateToChild = {
      title: 'Strona Główna',
      list: this.list,
      lackResource: 'kart',
      hideBack: true,
      iconColors: this.colors
    }; }
}
