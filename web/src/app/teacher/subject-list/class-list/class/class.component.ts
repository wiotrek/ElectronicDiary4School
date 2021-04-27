import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DateToChoiceCard } from 'src/app/_models/date-to-choice-card';
import { ListToCard } from 'src/app/_models/list-to-card';

@Component({
  selector: 'app-class',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class ClassComponent {
  dateToChild: DateToChoiceCard;

  list: ListToCard[] = [
    { name: 'Lista obecności', icon: 'bi bi-card-checklist' },
    { name: 'Oceny', icon: 'bi bi-file-earmark-spreadsheet' }
  ];

  colors = ['#F4A460', '#7FFFD4'];

  constructor(
    private route: ActivatedRoute
  ) { this.dateToChild = {
      title: this.getParam(),
      list: this.list,
      lackResource: 'kart',
      iconColors: this.colors
    }; }

  // take a param from link and set as title example 'Polski 3D'
  getParam(): string {
    const getSubject = this.route.snapshot.paramMap.get('subject');
    const getSchoolClass = this.route.snapshot.paramMap.get('class');

    if (getSubject && getSchoolClass) {
      let subject = getSubject.charAt(0).toUpperCase() + getSubject.slice(1);
      subject = subject.replace(/-/g, ' ');
      return `${subject} - ${getSchoolClass}`;
    }
    return 'Wybierz:';
  }

}
