import { Component, Input, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { TeacherService } from 'src/app/_services/teacher.service';
import { TeacherChoiceCard } from 'src/app/_models/teacher-choice-card';

@Component({
  selector: 'app-choice-card',
  templateUrl: './choice-card.component.html',
  styleUrls: ['./choice-card.component.css']
})
export class ChoiceCardComponent implements OnInit {
  @Input() dateFromParent = {} as TeacherChoiceCard;

  icons: string[] = [];
  iconColors: string[] = [];

  constructor(
    private location: Location,
    private ts: TeacherService
  ) { }

  ngOnInit(): void {
    this.icons = this.ts.defaultIcons.sort(() => Math.random() - 0.5);
    this.iconColors = this.ts.randomColor.sort(() => Math.random() - 0.5);
  }

  back(): void {
    this.location.back();
  }

}
