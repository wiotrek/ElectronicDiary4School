import { Component, Input } from '@angular/core';
import { Location } from '@angular/common';

@Component({
  selector: 'app-second-nav',
  template: `
  <h4 class="mini-nav">
    <a class="mini-nav__back" *ngIf="!this.parent?.hideBack"
    (click)="this.back()">Wróć</a>
    <span class="mini-nav__title">{{this.parent.title}}</span>
  </h4>
  `,
  styleUrls: ['./second-nav.component.css']
})
export class SecondNavComponent {
  @Input() parent: any;

  constructor(private location: Location) { }

  back = () => this.location.back();
}
