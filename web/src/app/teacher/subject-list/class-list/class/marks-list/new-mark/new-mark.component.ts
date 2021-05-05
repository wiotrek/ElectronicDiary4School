import { formatDate, Location } from '@angular/common';
import { Component, OnInit, ViewChild } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ActivatedRoute } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { AddNewMarks } from 'src/app/_models/_teacher/marks/new-mark/add-new-marks';
import { Revision } from 'src/app/_models/_teacher/marks/new-mark/revision';
import { StudentWithDefaultMark } from 'src/app/_models/_teacher/marks/new-mark/student-with-default-mark';
import { Student } from 'src/app/_models/_teacher/student';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-new-mark',
  templateUrl: './new-mark.component.html',
  styleUrls: ['./new-mark.component.css']
})
export class NewMarkComponent implements OnInit {
  @ViewChild('f') form: NgForm | undefined;
  toChild = { title: 'Nowa ocena' };
  list: StudentWithDefaultMark[] = [];
  revision = {} as Revision;
  typeofAssigment = [
    'Sprawdzian', 'Kartkówka', 'Odpowiedź', 'Praca domowa'
  ];

  constructor(
    private route: ActivatedRoute,
    private location: Location,
    private toastr: ToastrService,
    private teacherService: TeacherService
  ) { }

  ngOnInit(): void {
    this.revision.kindOf = 'Kartkówka';
    this.getStudents();
  }

  getStudents(): void {

    // getting student list and added default mark = 1,
    // which then teacher can change
    this.teacherService
    // tslint:disable-next-line: deprecation
    .getStudents(this.route.snapshot.paramMap.get('class') || '').subscribe(
      (res: Student[]) => {
        this.list = res.reduce((result: StudentWithDefaultMark[], current: Student)
        : StudentWithDefaultMark[] => {
          result.push({ student: current, mark: 1 });
          return result; }, []);
      }, (err: any) => console.log(err));
  }

  // my own validation control,
  // this way is simillar than using formbuilder - trust me
  checkValue($event: any): void {

    // checking in array [1, 2..6]
    const isExist = [...Array(7).keys()].slice(1)
      .find(x => x === Number($event.target.value));

    // if given mark is beyond range then setting mark = 1
    if (!isExist) {
      $event.target.value = 1;
      this.toastr.warning('Nie ma takiej oceny');
    }
  }

  save(el: HTMLElement): void {

    // if topic have not been found then func return and scrool up
    if (this.form?.value?.topic === undefined
      || this.form?.value?.topic === '') {
      this.toastr.warning('Wprowadź temat');
      el.scrollIntoView({behavior: 'smooth', block: 'center'});
      return;
    }

    const getDate = formatDate(new Date(), 'yyyy-MM-dd', 'en-Us');
    const subject = this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || '');

    // creating unecessery object to send on backend
    const addNewMarks: AddNewMarks = {
      revision: this.form?.value as Revision,
      marks: this.list.reduce((total: any, current: StudentWithDefaultMark): any => {
        total.push({ identifier: current.student.identifier, mark: current.mark });
        return total; }, []) };

    this.teacherService.sendNewMark(subject, getDate, addNewMarks).subscribe(
      () => {
        console.log('udało się');
        this.toastr.success('Ocena została dodana');
        this.location.back();
      }, (err: any) => {
        console.log(err);
        this.toastr.error('Niestety, nie udało się dodać oceny'); });
  }

}
