import { Component, OnInit } from '@angular/core';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-subject-list',
  templateUrl: './subject-list.component.html',
  styleUrls: ['./subject-list.component.css']
})
export class SubjectListComponent implements OnInit {

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

  icons: string[] = [];
  iconColors: string[] = [];

  constructor(
    private ts: TeacherService
  ) { }

  ngOnInit(): void {
    this.icons = this.ts.defaultIcons.sort(() => Math.random() - 0.5);
    this.iconColors = this.ts.randomColor.sort(() => Math.random() - 0.5);
  }

}
