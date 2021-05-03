import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Student } from 'src/app/_models/models_teacher/student';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-new-mark',
  templateUrl: './new-mark.component.html',
  styleUrls: ['./new-mark.component.css']
})
export class NewMarkComponent implements OnInit {
  toChild = { title: 'Nowa ocena' };
  typeofAssigment = [
    'Kartkówka', 'Sprawdzian', 'Odpowiedź ustna'
  ];
  list: Student[] = [];


  constructor(
    private route: ActivatedRoute,
    private teacherService: TeacherService
  ) { }

  ngOnInit(): void {
    this.getStudents();
  }

  getStudents(): void {
    const getClassName = this.route.snapshot.paramMap.get('class') || '';

    // tslint:disable-next-line: deprecation
    this.teacherService.getStudents(getClassName).subscribe(
      (res: Student[]) => this.list = res,
      (err: any) => console.log(err));
  }

}
