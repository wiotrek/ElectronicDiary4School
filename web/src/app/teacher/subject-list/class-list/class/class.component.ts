import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ChoiceCard } from 'src/app/_models/choice-card';
import { Dictionary } from 'src/app/_models/dictionary';

@Component({
  selector: 'app-class',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class ClassComponent {
  dateToChild = {} as ChoiceCard;

  list: Dictionary<string, string>[] = [
    { key: 'Lista obecności', value: 'bi bi-card-checklist' },
    { key: 'Oceny', value: 'bi bi-file-earmark-spreadsheet' }
  ];

  colors = [
    '#F4A460',
    '#7FFFD4'
  ];

  constructor(
    private route: ActivatedRoute
  ) { this.dateToChild = {
      title: this.getParam(),
      list: this.list,
      iconColors: this.colors
    }; }

  // take a param from link and set as title example 'Polski 3D'
  getParam(): string {
    const getSubject = this.route.snapshot.paramMap.get('subject');
    const getSchoolClass = this.route.snapshot.paramMap.get('class');

    if (getSubject != null && getSchoolClass) {
      const subject = getSubject.charAt(0).toUpperCase() + getSubject.slice(1);
      const arrSchoolClass = getSchoolClass.split('-');
      return `${subject} ${arrSchoolClass[1].toUpperCase()}`;
    }
    return 'Wybierz:';
  }

}
