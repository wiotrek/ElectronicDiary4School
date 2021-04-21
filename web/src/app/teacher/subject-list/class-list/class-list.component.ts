import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
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

  list: Dictionary<string, string>[] = [];

  constructor(
    private teacherService: TeacherService,
    private route: ActivatedRoute
  )
  {
    this.dateToChild = {
      title: 'Wybierz klase',
      list: this.list,
      lackResource: 'klas',
    };
    this.getParam();
  }

  getParam(): void {
    const getSubject = this.route.snapshot.paramMap.get('subject');
    if (getSubject) {
      // let subject = getSubject.charAt(0).toUpperCase() + getSubject.slice(1);
      // subject = subject.replace(/-/g, ' ');
      this.load(getSubject);
    }
    return;
  }

  load(subject: string): void {
    this.teacherService.getClasses(subject).subscribe((res: any) => {
      res.forEach(({klasa, Icon}: any) =>
      this.list.push({key: klasa, value: Icon}));
    }, (err: any) => console.log(err));
  }

}
