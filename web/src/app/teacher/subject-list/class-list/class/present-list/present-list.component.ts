import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { StudentPresentList } from 'src/app/_models/models_teacher/student-present-list';
import { formatDate } from '@angular/common';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-present-list',
  templateUrl: './present-list.component.html',
  styleUrls: ['./present-list.component.css']
})
export class PresentListComponent implements OnInit {
  form: FormGroup;
  today: Date;
  toChild = {
    title: 'Lista obecności'
  };

  // list which is getting from api to display
  studentsList: StudentPresentList[] = [];

  constructor(
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private teacherService: TeacherService) {
    this.today = new Date();

    this.form = this.formBuilder.group({
      studentsPresent: this.formBuilder.array([])
    });
  }

  ngOnInit(): void {
    this.getStudentsList();
  }

  getStudentsList(): void {
    const getClassName = this.route.snapshot.paramMap.get('class') || 'undefined';

    this.teacherService.getStudents(getClassName).subscribe(
      (res: StudentPresentList[]) => this.studentsList = res,
      (err: any) => console.log(err));
  }

  // getting array students and in sequence adding values users
  // who are checked
  onCheckboxChange(e: any): void {
    const studentPresent: FormArray = this.form.get('studentsPresent') as FormArray;
    if (e.target.checked) {
      studentPresent.push(new FormControl(e.target.value));
    } else {
      const index = studentPresent.controls.findIndex(x => x.value === e.target.value);
      studentPresent.removeAt(index);
    }
  }

  saveList(): void {
    // prevent default type - date
    const correctDate = typeof this.today === 'string'
    ? this.today : formatDate(this.today, 'yyyy-MM-dd', 'en-Us');

    const getSubject = this.route.snapshot.paramMap.get('subject') || 'undefined';
    const subject = getSubject.charAt(0).toUpperCase() + getSubject.slice(1);

    this.teacherService
      .sendPresentList(subject, correctDate, this.form.value.studentsPresent)
      .subscribe(
        () => console.log('udalo sie'),
        (err: any) => console.log(err));
  }

}
