import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { Student } from 'src/app/_models/models_teacher/student';
import { formatDate } from '@angular/common';
import { TeacherService } from 'src/app/_services/teacher.service';
import { ToastrService } from 'ngx-toastr';

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
  studentsList: Student[] = [];

  constructor(
    private route: ActivatedRoute,
    private formBuilder: FormBuilder,
    private teacherService: TeacherService,
    private toastr: ToastrService) {
    this.today = new Date();

    this.form = this.formBuilder.group({
      studentsPresent: this.formBuilder.array([])
    });
  }

  ngOnInit(): void {
    this.getStudentsList();
  }

  getStudentsList(): void {
    const getClassName = this.route.snapshot.paramMap.get('class') || '';

    // tslint:disable-next-line: deprecation
    this.teacherService.getStudents(getClassName).subscribe(
      (res: Student[]) => this.studentsList = res,
      (err: any) => console.log(err));
  }

  // getting array students and in sequence adding values users
  // who are checked
  onCheckboxChange(e: any): void {
    const studentPresent: FormArray = this.form.get('studentsPresent') as FormArray;
    if (e.target.checked) { studentPresent.push(new FormControl(e.target.value)); }
    else {
      const index = studentPresent.controls.findIndex(x => x.value === e.target.value);
      studentPresent.removeAt(index);
    }
  }

  saveList(): void {

    // prevent default type - date
    const correctDate = typeof this.today === 'string'
    ? this.today : formatDate(this.today, 'yyyy-MM-dd', 'en-Us');

    const subject = this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || '');

    this.teacherService
      .sendPresentList(subject, correctDate, this.form.value.studentsPresent)
      .subscribe(() => {
        this.toastr.success('Obecność została zarejestrowana');
      }, (err: any) => this.toastr.error('Nie udało się zarejestrować obecności'));
  }
}
