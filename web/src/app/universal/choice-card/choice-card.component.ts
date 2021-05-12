import { Component, Input, OnInit } from '@angular/core';
import { Card } from 'src/app/_models/_universal/card';
import { DateToChoiceCard } from '../../_models/date-to-choice-card';

@Component({
  selector: 'app-choice-card',
  template: `
  <main>
  <app-second-nav [parent]="toSecondNav"></app-second-nav>

  <div class="cards">
      <app-card *ngFor="let item of this.dateFromParent.list; index as i"
      [colorCard]="this.iconsColor[i % this.iconsColor.length]" [dateCard]="item"></app-card>
  </div>

  <ng-template #lackResource>
      <h5 class="error">
        Niestety, nie posiadasz żadnych {{this.dateFromParent.lackResource}}</h5>S
  </ng-template>

  </main>`,
   styles: ['.error { margin-top: 2vh; animation: appear 10s ease-in-out .5s backwards }']
})
export class ChoiceCardComponent implements OnInit {
  @Input() dateFromParent = {} as DateToChoiceCard;
  dateToCard = {} as Card[];
  toSecondNav = {};

  // current color icons doesnt matter whether color
  // is from default color, whether come from dateFromParent
  // beacause they will here
  iconsColor: string[] = [];

  // if parent component doesnt give color list, then
  // colors will from this list
  defaultColors = [
    '#FFB6C1', '#90EE90', '#20B2AA', '#87CEFA',
    '#F0E68C', '#FF6347', '#D3D3D3', '#E6E6FA',
    '#87CEEB', '#4682B4', '#F4A460', '#7FFFD4'
  ];

  ngOnInit(): void {

    // adding params to second navbar
    this.toSecondNav = {
      hideBack: this.dateFromParent.hideBack,
      title: this.dateFromParent.title
    };

    // if iconColors doesnt exist then setting self default colors
    this.iconsColor = this.dateFromParent.iconColors ?
    this.dateFromParent?.iconColors.sort(() => Math.random() - 0.5)
    : this.defaultColors.sort(() => Math.random() - 0.5);
  }
}
