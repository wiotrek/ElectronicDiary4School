import { Component } from '@angular/core';
import { ChoiceCard } from '../_models/choice-card';
import { Dictionary } from '../_models/dictionary';

@Component({
  selector: 'app-teacher',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class TeacherComponent {
  dateToChild = {} as ChoiceCard;

  // static list
  list: Dictionary<string, string>[] = [
    { key: 'Rozpocznij lekcje', value: 'bi bi-subtract' },
    { key: 'Powiadomienia', value: 'bi bi-chat-dots' }
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
      hideBack: true,
      iconColors: this.colors
    }; }
}
