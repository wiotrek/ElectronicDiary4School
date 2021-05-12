import { Component, OnInit } from '@angular/core';
import { DateToChoiceCard } from 'src/app/_models/_universal/date-to-choice-card';
import { Card } from 'src/app/_models/_universal/card';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-subject-list',
  template: `<app-choice-card [dateFromParent]="dateToChild"></app-choice-card>`
})
export class SubjectListComponent implements OnInit{
  dateToChild: DateToChoiceCard;

  list: Card[] = [];

  constructor(private teacherService: TeacherService){
    this.dateToChild = {
      title: 'Wybierz przedmiot',
      list: this.list,
      lackResource: 'przedmiotów'
    };
  }

  ngOnInit(): void {

    // unfortunaly i can assign directly response to this.list
    this.teacherService.getSubjects().subscribe((res: Card[]) =>
      res.forEach(({name, icon}) => this.list.push({name, icon})));
  }
}
