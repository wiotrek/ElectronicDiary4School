import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ChoiceCard } from 'src/app/_models/choice-card';

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

  list = [
    'Lista obecności',
    'Oceny'
  ];

  constructor(
    private route: ActivatedRoute
  ) {
    this.dateToChild.title = this.getParam();
    this.dateToChild.list = this.list;
  }

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
