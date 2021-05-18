import { Component, Input } from '@angular/core';
import { Marks } from 'src/app/_models/_student/marks/marks';

@Component({
  selector: 'app-details-mark',
  template: `
  <div class="marks">
  <p class="ones-mark__p--pc">Pozycja na tle grupy: {{position}}</p>
    <div class="ones-mark" *ngFor="let mark of marks">
        <p class="ones-mark__p--mobile">{{mark.mark}} - {{mark.kindOf}}</p>
        <p class="ones-mark__p--pc">
          <span>ocena: {{mark.mark}}</span>
          <span>{{mark.topic}}</span>
          <span>{{mark.kindOf}} {{mark.date}}</span>
        </p>
    </div>
  </div>
  `, styleUrls: ['./details-mark.component.css']
})
export class DetailsMarkComponent {
  @Input() marks = {} as Marks[];
  @Input() position: number | undefined;
}
