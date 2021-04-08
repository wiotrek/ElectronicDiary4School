import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ClassListComponent } from './teacher/subject-list/class-list/class-list.component';
import { SubjectListComponent } from './teacher/subject-list/subject-list.component';
import { TeacherComponent } from './teacher/teacher.component';

const routes: Routes = [
  { path: 'nauczyciel', component: TeacherComponent },
  { path: 'nauczyciel/:choice', component: SubjectListComponent },
  { path: 'nauczyciel/:choice/:subject', component: ClassListComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
