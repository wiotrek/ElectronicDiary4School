import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { SubjectListComponent } from './teacher/subject-list/subject-list.component';
import { TeacherComponent } from './teacher/teacher.component';

const routes: Routes = [
  { path: 'nauczyciel', component: TeacherComponent },
  { path: 'nauczyciel/lista-przedmiotow', component: SubjectListComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
