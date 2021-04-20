import { Component } from '@angular/core';
import { ChoiceCard } from 'src/app/_models/choice-card';
import { Dictionary } from 'src/app/_models/dictionary';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-subject-list',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class SubjectListComponent{
  dateToChild = {} as ChoiceCard;

  list: Dictionary<string, string>[] = [];

  constructor(private teacherService: TeacherService){
    this.dateToChild = {
      title: 'Wybierz przedmiot',
      list: this.list,
      lackResource: 'przedmiotów'
    };

    this.load();
  }

  load(): void {
    this.teacherService.getSubjects().subscribe((res: any) =>
      res.forEach(({name, icon}: any) =>
        this.list.push({key: name, value: icon})));
  }
}
