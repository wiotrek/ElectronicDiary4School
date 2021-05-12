import { Component } from '@angular/core';
import { DateToChoiceCard } from 'src/app/_models/date-to-choice-card';
import { ListToCard } from 'src/app/_models/list-to-card';
import { Card } from 'src/app/_models/_universal/card';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-subject-list',
  template: `<app-choice-card [dateFromParent]="dateToChild"></app-choice-card>`
})
export class SubjectListComponent{
  dateToChild: DateToChoiceCard;

  list: Card[] = [];

  constructor(private teacherService: TeacherService){
    this.dateToChild = {
      title: 'Wybierz przedmiot',
      list: this.list,
      lackResource: 'przedmiotów'
    };

    this.load();
  }

  load(): void {
    // tslint:disable-next-line: deprecation
    this.teacherService.getSubjects().subscribe((res: ListToCard[]) =>
      res.forEach(({name, icon}: ListToCard) =>
        this.list.push({description: name, icon})));
  }
}
