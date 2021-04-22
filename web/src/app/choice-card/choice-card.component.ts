import { Component, Input, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { ChoiceCard } from '../_models/choice-card';

@Component({
  selector: 'app-choice-card',
  templateUrl: './choice-card.component.html',
  styleUrls: ['./choice-card.component.css']
})
export class ChoiceCardComponent implements OnInit {
  @Input() dateFromParent = {} as ChoiceCard;

  // current color icons doesnt matter whether color
  // is from default color, whether come from dateFromParent
  // beacause they will here
  iconsColor: string[] = [];

  // if parent component doesnt give color list, then
  // colors will from this list
  defaultColors = [
    '#FFB6C1', '#90EE90', '#20B2AA', '#87CEFA',
    '#F0E68C', '#FF6347', '#D3D3D3', '#E6E6FA',
    '#87CEEB', '#4682B4', '#F4A460', '#7FFFD4'
  ];

  constructor(private location: Location) {}

  // if iconColors doesnt exist then setting self default colors
  ngOnInit(): void {
    this.iconsColor = this.dateFromParent.iconColors ?
    this.dateFromParent?.iconColors.sort(() => Math.random() - 0.5)
    : this.defaultColors.sort(() => Math.random() - 0.5);
  }

  back = () => this.location.back();

  // replace all white space on dash
  // between /{sign}/g is a sign which we want change
  createLink = (item: string) => item.replace(/\s+/g, '-').toLowerCase();
}
