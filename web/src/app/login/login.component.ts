import { Component, ElementRef, OnInit } from '@angular/core';
import { AccountService } from '../_services/account.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  model: any = {};

  constructor(
    private elementRef: ElementRef,
    private accountService: AccountService
  ) {
   }

  ngOnInit(): void {
    // setting background color for body element
    this.elementRef.nativeElement.ownerDocument.body.classList.add('bgForLoggingComponent');
  }

  login(): void {
    const result = this.accountService.login(this.model);
    console.log(result);
  }

}
