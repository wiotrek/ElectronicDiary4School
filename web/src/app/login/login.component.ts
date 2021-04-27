import { Component, ElementRef, OnInit, ViewChild } from '@angular/core';
import { AccountService } from '../_services/account.service';
import { ToastrService } from 'ngx-toastr';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  @ViewChild('loginForm') loginForm: NgForm | undefined;
  model: any = {};

  constructor(
    private elementRef: ElementRef,
    private accountService: AccountService,
    private toastr: ToastrService
  ) {
   }

  ngOnInit(): void {
    // setting background color for body element
    this.elementRef.nativeElement.ownerDocument.body.classList.add('bg-logging');
  }

  login(): void {
    this.accountService.login(this.model).subscribe(
      () => window.location.reload(),
      (err: any) => {
        this.loginForm?.reset();
        this.toastr.error('Nie udało się zalogować');
    });
  }
}
