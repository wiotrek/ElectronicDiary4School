import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Student } from 'src/app/_models/_teacher/student';
import { TeacherService } from 'src/app/_services/teacher.service';
import { ToastrService } from 'ngx-toastr';
import { StudentActivity } from 'src/app/_models/_teacher/activity/student-activity';

@Component({
  selector: 'app-activity-list',
  templateUrl: './activity-list.component.html',
  styleUrls: ['./activity-list.component.css']
})
export class ActivityListComponent implements OnInit {

  // list which is getting from api to display
  list: StudentActivity[] = [];

  constructor(
    private teacherService: TeacherService,
    private route: ActivatedRoute,
    private toastr: ToastrService) {}

  ngOnInit(): void {
    this.getStudentsList();
  }

  getStudentsList(): void {
    this.teacherService.getStudents(this.route.snapshot.paramMap.get('class') || '')
      .subscribe(
        (res: Student[]) => {
          this.list = res.reduce((result: StudentActivity[], current: Student)
          : StudentActivity[] => {
            result.push({ student: current, isActivity: false });
            return result; }, []);
        }, (err: any) => console.log(err));
  }

  saveList(): void {
    const subject = this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || '');

    const a = [...this.list].reduce((total: any, current: StudentActivity): any => {
      total.push({identifier: current.student.identifier, isActivity: current.isActivity});
      return total;
    }, []);

    console.log(a);
    // this.teacherService
    //   .sendPresentList(subject, formatDate(new Date(), 'yyyy-MM-dd', 'en-Us'),
    //   this.form.value.studentsPresent)
    //   .subscribe(() => this.toastr.success('Obecność została zarejestrowana'));
  }
}
