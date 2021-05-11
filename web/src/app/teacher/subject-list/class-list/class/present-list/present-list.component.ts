import { Component } from '@angular/core';
import { formatDate } from '@angular/common';

@Component({
  selector: 'app-present-list',
  templateUrl: './present-list.component.html',
  styleUrls: ['./present-list.component.css']
})
export class PresentListComponent {
  today: Date;
  choiceDay: Date;
  activityListBool = true;
  toChild = { title: 'Lista obecności' };

  constructor() {
    this.today = new Date();
    this.choiceDay = new Date();
  }

  settingDate($event: any): void {
    this.choiceDay = $event;
    this.choiceDay.toString() === formatDate(this.today, 'yyyy-MM-dd', 'en-Us')
    ? this.activityListBool = true : this.activityListBool = false;
  }
}
