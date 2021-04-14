import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { NgbDropdown, NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { HttpClientModule } from '@angular/common/http';

// tslint:disable-next-line: typedef
export function tokenGetter() {
  return localStorage.getItem('user');
}

@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    FormsModule,
    HttpClientModule
  ],
  exports: [
    FormsModule,
    NgbModule
  ],
  providers: [
    NgbDropdown
  ]
})
export class SharedModule { }
