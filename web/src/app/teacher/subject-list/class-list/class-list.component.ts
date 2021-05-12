import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { DateToChoiceCard } from 'src/app/_models/_universal/date-to-choice-card';
import { Card } from 'src/app/_models/_universal/card';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-class-list',
  template: `<app-choice-card [dateFromParent]="dateToChild"></app-choice-card>`
})
export class ClassListComponent implements OnInit{
  dateToChild: DateToChoiceCard;

  list: Card[] = [];

  constructor(
    private teacherService: TeacherService,
    private route: ActivatedRoute){
    this.dateToChild = {
      title: 'Wybierz klase',
      list: this.list,
      lackResource: 'klas',
    };
  }

  ngOnInit(): void {
    const subject = this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || '');

    // unfortunaly i can assign directly response to this.list
    this.teacherService.getClasses(subject).subscribe((res: Card[]) =>
      res.forEach(({name, icon}) =>  this.list.push({name, icon})));
  }
}
