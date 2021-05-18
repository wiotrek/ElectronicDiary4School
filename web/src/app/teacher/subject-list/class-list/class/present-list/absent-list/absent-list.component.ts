import { Component, Input, OnInit } from '@angular/core';
import { StudentActivity } from 'src/app/_models/_teacher/activity/student-activity';

@Component({
  selector: 'app-absent-list',
  template: `
  <h2>Lista obecności z tego dnia</h2>
    <ul>
        <li class="global-list-element center-elements"
        *ngFor="let s of list; index as i" [ngClass]="{'global-list-element--unSelect': !s.isActive}">
        <p>{{i+1}}. {{s.student.first_name}} {{s.student.last_name}}
        <span [ngStyle]="{'color': 'var(--primary-blue)'}"> {{s.student.identifier}}</span></p>
        <i [ngClass]="s.isActive ? 'fa fa-check'  : 'fa fa-times'"
        [ngStyle]="{'color': s.isActive ? '#7FFFD4' : '#CD5C5C'}"></i></li></ul>
  `,
  styles: [
    'p {display: inline; margin: 0; padding: 0}',
    '.center-elements {display: flex; justify-content: space-between; align-items: baseline;}'
  ]
})
export class AbsentListComponent {
  @Input() list = {} as StudentActivity[];
}
