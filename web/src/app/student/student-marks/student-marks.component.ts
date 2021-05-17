import { Component, OnInit } from '@angular/core';
import { Card } from 'src/app/_models/_universal/card';
import { StudentService } from 'src/app/_services/student.service';

@Component({
  selector: 'app-student-marks',
  templateUrl: './student-marks.component.html',
  styleUrls: ['./student-marks.component.css']
})
export class StudentMarksComponent implements OnInit {
  toChild = {  title: 'Twoje oceny' };
  toHeader: Card[];
  toList = {} as Card[];

  constructor(private studentService: StudentService) {
    this.toHeader = this.fillHeader();
   }

  ngOnInit(): void {
    this.studentService.getSubjects().subscribe(
      (res: any) => {
        res.foreach((x: any) => this.toList.push({name: x}));
      }
      );
  }

  fillHeader = () => [
    {
      caption: '75%',
      color: '#7FFFD4',
      name: 'Twoja frekwencja',
      readonly: true
    },
    {
      caption: '4.21',
      color: '#7FFFD4',
      name: 'Twoja średnia',
      readonly: true
    }
  ]

}
