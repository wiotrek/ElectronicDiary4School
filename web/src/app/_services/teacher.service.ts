import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class TeacherService {

  constructor() { }

  defaultIcons = [
    'fa fa-car',
    'fa fa-rocket',
    'fa fa-ship',
    'fa fa-space-shuttle',
    'fa fa-subway',
    'fa fa-bus',
    'fa fa-ticket',
    'fa fa-trophy',
    'fa fa-umbrella',
    'fa fa-tint',
    'fa fa-university',
    'fa fa-music',
    'fa fa-bolt'
  ];

  randomColor = [
    '#7FFF00',
    '#0000FF',
    '#FF7F50',
    '#008B8B',
    '#FF8C00',
    '#00BFFF',
    '#FF1493',
    '#E9967A',
    '#228B22',
    '#ADFF2F',
    '#E0FFFF',
  ];

}
