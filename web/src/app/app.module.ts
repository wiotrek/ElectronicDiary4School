import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavComponent } from './nav/nav.component';
import { LoginComponent } from './login/login.component';
import { TeacherComponent } from './teacher/teacher.component';
import { SharedModule } from './_modules/shared/shared.module';
import { SubjectListComponent } from './teacher/subject-list/subject-list.component';
import { ChoiceCardComponent } from './teacher/choice-card/choice-card.component';
import { ClassListComponent } from './teacher/subject-list/class-list/class-list.component';

@NgModule({
  declarations: [
    AppComponent,
    NavComponent,
    LoginComponent,
    TeacherComponent,
    SubjectListComponent,
    ChoiceCardComponent,
    ClassListComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    SharedModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
