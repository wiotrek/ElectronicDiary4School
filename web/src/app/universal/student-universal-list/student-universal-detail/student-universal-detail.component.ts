import { Component, Input } from '@angular/core';
import { Subjects } from 'src/app/_models/_student/subjects';

@Component({
  selector: 'app-student-universal-detail',
  templateUrl: './student-universal-detail.component.html',
  styleUrls: ['./student-universal-detail.component.css']
})
export class StudentUniversalDetailComponent { @Input() parent = {} as Subjects; }
