import { Component } from '@angular/core';
import { Location } from '@angular/common';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { StudentPresentList } from 'src/app/_models/models_teacher/student-present-list';
import { formatDate } from '@angular/common';

@Component({
  selector: 'app-present-list',
  templateUrl: './present-list.component.html',
  styleUrls: ['./present-list.component.css']
})
export class PresentListComponent {
  form: FormGroup;
  today: Date;
  subject: string;
  toChild = {
    title: 'Lista obecności'
  };

  // list which is getting from api to display
  studentsList: StudentPresentList[] = [
    {userId: '123', name: 'Agnieszka', lastname: 'Antczak'},
    {userId: '421', name: 'Marek', lastname: 'Nowak'},
    {userId: '89', name: 'Mariola', lastname: 'Stasiak'},
    {userId: '541', name: 'Jadwiga', lastname: 'Olczak'}
  ];

  constructor(
    private location: Location,
    private route: ActivatedRoute,
    private formBuilder: FormBuilder) {
    this.today = new Date();

    // subject name is getting from path
    this.subject = this.route.snapshot.paramMap.get('subject') ?
    this.route.snapshot.paramMap.get('subject')?.replace(/-/g, ' ') || 'error'
    : 'error';

    this.form = this.formBuilder.group({
      subject: new FormControl(this.subject, Validators.required),
      studentsPresent: this.formBuilder.array([])
    });
  }

  back = () => this.location.back();

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

    // creating new object because exist problem with adding date
    // directly to formGroup
    const sendObject = {
      subject: this.form.value.subject,
      studentsPresent: this.form.value.studentsPresent,
      lessonDate: correctDate
    };

    console.log(sendObject);
  }

}
