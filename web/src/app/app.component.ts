import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { User } from './_models/user';
import { AccountService } from './_services/account.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  userExist = false;
  title = 'web';

  constructor(
    private accountService: AccountService,
    private router: Router
  ) {}

  ngOnInit(): void {
    this.setCurrentUser();
  }

  // step 1
  // this spot we check localstorage and setting current user
  setCurrentUser(): void {
    const getItem = localStorage.getItem('user');

    if (!!getItem) {
      const user: User = JSON.parse(getItem);
      this.accountService.setCurrentUser(user);
      this.isUserExist();
      return;
    }
    this.accountService.setCurrentUser(null);
    this.isUserExist();
  }

  // step 2
  isUserExist(): void {
    let isExist = false;
    // tslint:disable-next-line: deprecation
    this.accountService.currentUser$.subscribe(
      res => {
        isExist = !!res?.user.identifier;
        !!res?.role ? this.setDirectSite(res?.role)
        : isExist = false;
      });

    this.userExist = isExist;
  }

  // step 3
  // check whether exist role, then redirect to specific component
  setDirectSite(userRoles: string): void {
    const url = this.accountService.roles[userRoles];

    // if you want in peace write on some compomnent,
    // then comment below
    // if (url) { this.router.navigateByUrl(url); }
  }
}
