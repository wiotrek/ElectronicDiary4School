import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DateToChoiceCard } from 'src/app/_models/date-to-choice-card';
import { ListToCard } from 'src/app/_models/list-to-card';
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
  dateToChild: DateToChoiceCard;

  list: ListToCard[] = [];

  constructor(
    private teacherService: TeacherService,
    private route: ActivatedRoute){
    this.dateToChild = {
      title: 'Wybierz klase',
      list: this.list,
      lackResource: 'klas',
    };
    this.load();
  }

  load(): void {
    const subject = this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || '');

    // tslint:disable-next-line: deprecation
    this.teacherService.getClasses(subject).subscribe((res: ListToCard[]) => {
      res.forEach(({name, icon}: ListToCard) =>
      this.list.push({name, icon}));
    }, (err: any) => console.log(err));
  }
}
