import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { ClassListComponent } from './teacher/subject-list/class-list/class-list.component';
import { SubjectListComponent } from './teacher/subject-list/subject-list.component';
import { TeacherComponent } from './teacher/teacher.component';
import { AuthGuard } from './_guards/auth.guard';

const routes: Routes = [
  {
    path: '',
    runGuardsAndResolvers: 'always',
    canActivate: [AuthGuard],
    children: [
      { path: 'nauczyciel', component: TeacherComponent, canActivate: [AuthGuard] },
      { path: 'nauczyciel/:choice', component: SubjectListComponent },
      { path: 'nauczyciel/:choice/:subject', component: ClassListComponent }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
