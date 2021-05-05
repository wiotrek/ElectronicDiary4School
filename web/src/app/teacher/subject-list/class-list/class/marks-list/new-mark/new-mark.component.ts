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
    'Kartkówka', 'Sprawdzian', 'Odpowiedź ustna'
  ];

  constructor(
    private route: ActivatedRoute,
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

  checkValue($event: any): void {
    const isExist = [...Array(7).keys()].slice(1)
      .find(x => x === Number($event.target.value));

    if (!isExist) { this.toastr.warning('Nie ma takiej oceny'); }
  }

  addMarks(el: HTMLElement): void {
    if (this.form?.value?.topic === undefined
      || this.form?.value?.topic === '') {
      this.toastr.warning('Wprowadź temat');
      el.scrollIntoView({behavior: 'smooth', block: 'center'});
      return;
    }

    const objToSend: AddNewMarks = {
      revision: this.form?.value as Revision,
      marks: this.list.reduce((total: any, current: StudentWithDefaultMark): any => {
        total.push({ identifier: current.student.identifier, mark: current.mark });
        return total; }, [])
    };

    console.log(objToSend);
  }

}
