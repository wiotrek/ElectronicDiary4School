import { Component, OnInit } from '@angular/core';
import { formatDate } from '@angular/common';
import { TeacherService } from 'src/app/_services/teacher.service';
import { ActivatedRoute } from '@angular/router';
import { StudentActivity } from 'src/app/_models/_teacher/activity/student-activity';
import { StudentActivityObj } from 'src/app/_models/_teacher/activity/student-activity-obj';
import { ActivityListEnum } from 'src/app/_enums/activity-list-enum';

// child comopnent activity list and abset list they dont have appriopriate name
// becase early they were doing something other

@Component({
  selector: 'app-present-list',
  templateUrl: './present-list.component.html',
  styleUrls: ['./present-list.component.css']
})
export class PresentListComponent implements OnInit{
  studentsList!: StudentActivity[];
  today: Date;
  choiceDay: Date;
  chosenList = ActivityListEnum.lackList;
  toChild = { title: 'Lista obecności' };

  // by means of this property, setting appriopriate ngtemplete
  checkDay = false;


  constructor(
    private teacherService: TeacherService,
    private route: ActivatedRoute) {
    this.today = new Date();
    this.choiceDay = new Date();
  }

  ngOnInit(): void {

    // loading date with correct date in string
    this.load(formatDate(this.today, 'yyyy-MM-dd', 'en-Us'));
  }

  load(date: string): void {

    this.teacherService
    .getStudentsActivity(this.route.snapshot.paramMap.get('class') || '',
    this.teacherService.delDashesAndUpperFirstLetter(this.route.snapshot.paramMap.get('subject') || ''),  date)
      .subscribe((res: StudentActivityObj) => {
        if (res.StudentActivity) {
          this.studentsList = res.StudentActivity;

          // if particulary day exist or was list activity then select true
          this.checkDay = true;

          // when getting param readonly then load comopnent absent-list
          if (res.readOnly) { this.chosenList = ActivityListEnum.postActivityList; }

          // otherwise if is property date, and TIME then loading activity list to do
          else { this.chosenList = ActivityListEnum.currentActivityList; }
        }
      }, (err: any) => console.log(err), // necessery beacuse interceptor handle errors
      () => {
        // section allways executed
        // so property is not true then loading ngTemplete - lacklist
        if (!this.checkDay) { this.chosenList = ActivityListEnum.lackList; }

        // on the end allways setting property on false
        this.checkDay = false;
      });
  }

  settingDate($event: any): void {
    this.choiceDay = $event;

    // after change date setting checkDay on false
    this.checkDay = false;

    // beacuse here loading function setting appropriate value for checkDay
    // and setting ngTemplete
    this.load(this.choiceDay.toString());
  }
}


