import { Component } from '@angular/core';
import { Location } from '@angular/common';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { StudentPresentList } from 'src/app/_models/models_teacher/student-present-list';

@Component({
  selector: 'app-present-list',
  templateUrl: './present-list.component.html',
  styleUrls: ['./present-list.component.css']
})
export class PresentListComponent {
  form: FormGroup;
  title = 'Lista obecności';
  today: Date;
  subject: string;

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
      lessonDate: new FormControl(this.today.toLocaleDateString(), Validators.required),
      studentsPresent: this.formBuilder.array([])
    });
  }

  back = () => this.location.back();

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
    console.log(this.form.value);
  }

}
