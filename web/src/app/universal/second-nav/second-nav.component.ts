import { Component, Input } from '@angular/core';
import { Location } from '@angular/common';

@Component({
  selector: 'app-second-nav',
  template: `
  <h4>
    <a class="back" *ngIf="!this.parent?.hideBack"
    (click)="this.back()">Wróć</a>
    <span class="title">{{this.parent.title}}</span>
  </h4>
  `,
  styleUrls: ['./second-nav.component.css']
})
export class SecondNavComponent {
  @Input() parent: any;

  constructor(private location: Location) { }

  back = () => this.location.back();
}
