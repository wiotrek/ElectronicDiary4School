import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { StudentsMarks } from 'src/app/_models/_teacher/marks/students-marks';
import { Student } from 'src/app/_models/_teacher/student';
import { formatDate } from '@angular/common';
import { TeacherService } from 'src/app/_services/teacher.service';
import { ToastrService } from 'ngx-toastr';

@Component({
  selector: 'app-activity-list',
  templateUrl: './activity-list.component.html',
  styleUrls: ['./activity-list.component.css']
})
export class ActivityListComponent implements OnInit {
  form: FormGroup;

  // list which is getting from api to display
  studentsList: Student[] = [];

  constructor(
    private formBuilder: FormBuilder,
    private teacherService: TeacherService,
    private route: ActivatedRoute,
    private toastr: ToastrService) {
    this.form = this.formBuilder.group({
      studentsPresent: this.formBuilder.array([])
    });
   }

   ngOnInit(): void {
    this.getStudentsList();
  }

  // getting students list from this same list like marks list
  // further change list on list without marks
  getStudentsList(): void {
    this.teacherService.getStudentsMarks(
      this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || ''),
      this.route.snapshot.paramMap.get('class') || '').subscribe(
      (res: StudentsMarks[]) => {
        this.studentsList = res.reduce((total: Student[], current: StudentsMarks)
        : Student[] => {
          total.push(current.student);
          return total; }, []);
      }, (err: any) => console.log(err));
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
    const subject = this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || '');

    this.teacherService
      .sendPresentList(subject, formatDate(new Date(), 'yyyy-MM-dd', 'en-Us'),
       this.form.value.studentsPresent)
      .subscribe(() => {
        this.toastr.success('Obecność została zarejestrowana');
      }, (err: any) => this.toastr.error('Nie udało się zarejestrować obecności'));
  }
}
