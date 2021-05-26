import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { NotFoundComponent } from './errors/not-found/not-found.component';
import { ChildActivityComponent } from './parent/child-activity.component';
import { ChildMarksComponent } from './parent/child-marks.component';
import { ParentComponent } from './parent/parent.component';
import { StudentActivityComponent } from './student/student-activity.component';
import { StudentMarksComponent } from './student/student-marks.component';
import { StudentComponent } from './student/student.component';
import { ClassListComponent } from './teacher/subject-list/class-list/class-list.component';
import { ClassComponent } from './teacher/subject-list/class-list/class/class.component';
import { MarksListComponent } from './teacher/subject-list/class-list/class/marks-list/marks-list.component';
import { NewMarkComponent } from './teacher/subject-list/class-list/class/marks-list/new-mark/new-mark.component';
import { PresentListComponent } from './teacher/subject-list/class-list/class/present-list/present-list.component';
import { SubjectListComponent } from './teacher/subject-list/subject-list.component';
import { TeacherComponent } from './teacher/teacher.component';
import { MessagesComponent } from './universal/messages/messages.component';
import { NewMessageComponent } from './universal/messages/new-message/new-message.component';
import { AuthGuard } from './_guards/auth.guard';
import { ParentGuard } from './_guards/parent.guard';
import { StudentGuard } from './_guards/student.guard';
import { TeacherGuard } from './_guards/teacher.guard';

const routes: Routes = [
  {
    path: '',
    runGuardsAndResolvers: 'always',
    canActivate: [AuthGuard],
    children: [
      {
        path: 'nauczyciel',
        canActivate: [TeacherGuard],
        children: [
          { path: '', component: TeacherComponent },
          {
            path: 'rozpocznij-lekcje',
            children: [
              { path: '' , component: SubjectListComponent },
              { path: ':subject', component: ClassListComponent },
              {
                path: ':subject/:class',
                children: [
                  { path: '', component: ClassComponent },
                  { path: 'lista-obecności', component:  PresentListComponent },
                  {
                    path: 'oceny',
                    children: [
                      { path: '', component: MarksListComponent },
                      { path: 'nowa-ocena', component: NewMarkComponent }
                    ]
                  }
                ]
              }
            ]
          },
          {
            path: 'powiadomienia',
            children: [
              { path: '', component: MessagesComponent },
              { path: 'nowa-wiadomość', component: NewMessageComponent }
            ]
          }
        ]
      },
      {
        path: 'uczen',
        canActivate: [StudentGuard],
        children: [
          { path: '', component: StudentComponent },
          {
            path: 'sprawdź-oceny',
            children: [
              { path: '', component: StudentMarksComponent }
            ]
          },
          {
            path: 'zobacz-frekwencje',
            children: [
              { path: '', component: StudentActivityComponent }
            ]
          }
        ]
      },
      {
        path: 'rodzic',
        canActivate: [ParentGuard],
        children: [
          { path: '', component: ParentComponent },
          {
            path: 'sprawdź-oceny',
            children: [
              { path: '', component: ChildMarksComponent }
            ]
          },
          {
            path: 'zobacz-frekwencje',
            children: [
              { path: '', component: ChildActivityComponent }
            ]
          },
          {
            path: 'powiadomienia',
            children: [
              { path: '', component: MessagesComponent },
              { path: 'nowa-wiadomość', component: NewMessageComponent }
            ]
          }
        ]
      },
      { path: 'not-found', component: NotFoundComponent },
      { path: '**', component: NotFoundComponent, pathMatch: 'full' }
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
