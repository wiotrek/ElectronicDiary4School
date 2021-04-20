import { Component } from '@angular/core';
import { ChoiceCard } from 'src/app/_models/choice-card';
import { Dictionary } from 'src/app/_models/dictionary';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-class-list',
  template: `
  <app-choice-card
  [dateFromParent]="dateToChild"
  ></app-choice-card>
  `
})
export class ClassListComponent {
  dateToChild = {} as ChoiceCard;

  list: Dictionary<string, string>[] = [
    { key: 'Klasa 4C', value: 'bi bi-suit-club' },
    { key: 'Klasa 6D', value: 'bi bi-suit-diamond' },
    { key: 'Klasa 7A', value: 'bi bi-suit-spade' },
  ];

  constructor(private teacherService: TeacherService)
  { this.dateToChild = {
      title: 'Wybierz klase',
      list: this.list,
      lackResource: 'klas',
    }; }

  load(): void {
    this.teacherService.getSubjects().subscribe((res: any) =>
      res.forEach(({name, icon}: any) =>
        this.list.push({key: name, value: icon})));
  }

}
