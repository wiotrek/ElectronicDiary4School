import { Component, Input } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { TeacherService } from 'src/app/_services/teacher.service';
import { ToastrService } from 'ngx-toastr';
import { StudentActivity } from 'src/app/_models/_teacher/activity/student-activity';

@Component({
  selector: 'app-activity-list',
  templateUrl: './activity-list.component.html',
  styleUrls: ['./activity-list.component.css']
})
export class ActivityListComponent {
  @Input() list = {} as StudentActivity[];

  constructor(
    private teacherService: TeacherService,
    private route: ActivatedRoute,
    private toastr: ToastrService) { }

  saveList(): void {
    const subject = this.teacherService.delDashesAndUpperFirstLetter(
      this.route.snapshot.paramMap.get('subject') || '');

    this.teacherService.sendPresentList(subject, this.list).subscribe(
      () => this.toastr.success('Obecność została zarejestrowana'));
  }
}
