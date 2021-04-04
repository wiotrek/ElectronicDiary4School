import { Component, ElementRef, OnInit } from '@angular/core';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  model:any  = {};

  constructor(
    private elementRef: ElementRef
  ) {
   }

  ngOnInit(): void {
    // setting background color for body element
    this.elementRef.nativeElement.ownerDocument.body.classList.add('bgForLoggingComponent');
  }

  login(): void {
    console.log(this.model);
    
  }

}
