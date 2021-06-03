import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavComponent } from './nav/nav.component';
import { LoginComponent } from './login/login.component';
import { TeacherComponent } from './teacher/teacher.component';
import { SharedModule } from './_modules/shared/shared.module';
import { SubjectListComponent } from './teacher/subject-list/subject-list.component';
import { ChoiceCardComponent } from './universal/choice-card/choice-card.component';
import { ClassListComponent } from './teacher/subject-list/class-list/class-list.component';
import { ClassComponent } from './teacher/subject-list/class-list/class/class.component';
import { PresentListComponent } from './teacher/subject-list/class-list/class/present-list/present-list.component';
import { NotFoundComponent } from './errors/not-found/not-found.component';
import { MarksListComponent } from './teacher/subject-list/class-list/class/marks-list/marks-list.component';
import { AuthInterceptor } from './_interceptors/auth.interceptor';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { SecondNavComponent } from './universal/second-nav/second-nav.component';
import { EditMarksComponent } from './teacher/subject-list/class-list/class/marks-list/edit-marks/edit-marks.component';
import { LoadingInterceptor } from './_interceptors/loading.interceptor';
import { NewMarkComponent } from './teacher/subject-list/class-list/class/marks-list/new-mark/new-mark.component';
import { ActivityListComponent } from './teacher/subject-list/class-list/class/present-list/activity-list/activity-list.component';
import { ErrorInterceptor } from './_interceptors/error.interceptor';
import { AbsentListComponent } from './teacher/subject-list/class-list/class/present-list/absent-list/absent-list.component';
import { StudentComponent } from './student/student.component';
import { StudentMarksComponent } from './student/student-marks.component';
import { CardComponent } from './universal/card/card.component';
import { StudentActivityComponent } from './student/student-activity.component';
import { ParentComponent } from './parent/parent.component';
import { StudentUniversalListComponent } from './universal/student-universal-list/student-universal-list.component';
import { StudentUniversalDetailComponent } from './universal/student-universal-list/student-universal-detail/student-universal-detail.component';
import { ChildMarksComponent } from './parent/child-marks.component';
import { ChildActivityComponent } from './parent/child-activity.component';
import { MessagesComponent } from './universal/messages/messages.component';
import { NewMessageComponent } from './universal/messages/new-message/new-message.component';
import { HasRoleDirective } from './_directives/has-role.directive';
import { ReplyMessageComponent } from './universal/messages/reply-message/reply-message.component';

@NgModule({
  declarations: [
    AppComponent,
    NavComponent,
    LoginComponent,
    TeacherComponent,
    SubjectListComponent,
    ChoiceCardComponent,
    ClassListComponent,
    ClassComponent,
    PresentListComponent,
    NotFoundComponent,
    MarksListComponent,
    SecondNavComponent,
    EditMarksComponent,
    NewMarkComponent,
    ActivityListComponent,
    AbsentListComponent,
    StudentComponent,
    StudentMarksComponent,
    StudentUniversalListComponent,
    StudentUniversalDetailComponent,
    CardComponent,
    StudentActivityComponent,
    ParentComponent,
    ChildMarksComponent,
    ChildActivityComponent,
    MessagesComponent,
    NewMessageComponent,
    HasRoleDirective,
    ReplyMessageComponent

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    SharedModule
  ],
  providers: [
    { provide: HTTP_INTERCEPTORS, useClass: ErrorInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: LoadingInterceptor, multi: true }
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
