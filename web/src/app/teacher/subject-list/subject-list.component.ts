import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { TeacherChoiceCard } from 'src/app/_models/teacher-choice-card';

@Component({
  selector: 'app-subject-list',
  templateUrl: './subject-list.component.html',
  styleUrls: ['./subject-list.component.css']
})
export class SubjectListComponent implements OnInit {

  dateToChild = {} as TeacherChoiceCard;

  list = [
    'polski',
    'muzyka',
    'informatyka',
    'przyroda',
    'joga',
    'wf',
    'hiszpanski',
    'chemia',
    'fizyka'
  ];

  constructor(
    private location: Location
  ) {
    this.dateToChild.title = 'Wybierz przedmiot';
    this.dateToChild.list = this.list;
  }

  ngOnInit(): void {
  }

  back(): void {
    this.location.back();
  }
}
