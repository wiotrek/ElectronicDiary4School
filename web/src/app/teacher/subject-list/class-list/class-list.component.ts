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
  dateToChild = {} as DateToChoiceCard;

  list: ListToCard[] = [];

  constructor(
    private teacherService: TeacherService,
    private route: ActivatedRoute){
    this.dateToChild = {
      title: 'Wybierz klase',
      list: this.list,
      lackResource: 'klas',
    };
    this.getParam();
  }

  // getting subject name from path, then changes whitespace with dash
  // and gives prepare subject to send to api
  getParam(): void {
    const getSubject = this.route.snapshot.paramMap.get('subject') || '';
    let subject = getSubject.charAt(0).toUpperCase() + getSubject.slice(1);
    subject = subject.replace(/-/g, ' ');
    this.load(subject);
  }

  load(subject: string): void {
    this.teacherService.getClasses(subject).subscribe((res: ListToCard[]) => {
      res.forEach(({name, icon}: ListToCard) =>
      this.list.push({name, icon}));
    }, (err: any) => console.log(err));
  }
}
