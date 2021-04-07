import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { NgbDropdown, NgbModule } from '@ng-bootstrap/ng-bootstrap';



@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    FormsModule
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
