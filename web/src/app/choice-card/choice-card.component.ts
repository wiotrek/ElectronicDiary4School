import { Component, Input, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { TeacherService } from 'src/app/_services/teacher.service';
import { ChoiceCard } from '../_models/choice-card';

@Component({
  selector: 'app-choice-card',
  templateUrl: './choice-card.component.html',
  styleUrls: ['./choice-card.component.css']
})
export class ChoiceCardComponent implements OnInit {
  @Input() dateFromParent = {} as ChoiceCard;

  icons: string[] = [];
  defaultColors = [
    '#FFB6C1',
    '#90EE90',
    '#20B2AA',
    '#87CEFA',
    '#F0E68C',
    '#FF6347',
    '#D3D3D3',
    '#E6E6FA',
    '#87CEEB',
    '#4682B4',
    '#F4A460',
    '#7FFFD4'
  ];

  constructor(
    private location: Location,
    private ts: TeacherService
  ) {}

  // if iconColors doesnt exist then setting self default colors
  ngOnInit(): void {
    this.icons = this.dateFromParent.iconColors ?
    this.dateFromParent?.iconColors.sort(() => Math.random() - 0.5)
    : this.defaultColors.sort(() => Math.random() - 0.5);
  }

  back(): void {
    this.location.back();
  }

  createLink = (item: string) => {
    return item.replace(' ', '-').toLowerCase().toString();
  }
}
