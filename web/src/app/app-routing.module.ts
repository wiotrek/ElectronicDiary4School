import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { NotFoundComponent } from './errors/not-found/not-found.component';
import { ClassListComponent } from './teacher/subject-list/class-list/class-list.component';
import { ClassComponent } from './teacher/subject-list/class-list/class/class.component';
import { PresentListComponent } from './teacher/subject-list/class-list/class/present-list/present-list.component';
import { SubjectListComponent } from './teacher/subject-list/subject-list.component';
import { TeacherComponent } from './teacher/teacher.component';
import { AuthGuard } from './_guards/auth.guard';
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
              {path: '' , component: SubjectListComponent },
              { path: ':subject', component: ClassListComponent },
              { path: ':subject/:class', component: ClassComponent },
              { path: ':subject/:class/lista-obecności', component: PresentListComponent }
            ]
          }
        ],
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
