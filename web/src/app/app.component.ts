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
  userExist: boolean;
  title = 'web';

  constructor(
    private accountService: AccountService,
    private router: Router
  ) { this.userExist = false; }

  ngOnInit(): void {
    this.setCurrentUser();
  }

  isUserExist(): any {
    let isUser;
    // tslint:disable-next-line: deprecation
    this.accountService.currentUser$.subscribe(res => {
      isUser = res?.message.identifier === undefined
        || res?.message.identifier === null ? true : false;

      //  if exist user role like teacher then set them
      if (res?.role !== undefined) {
        this.setPropertySite(res?.role);
      }
    });

    // if token is null then user exist so return info about user
    return !isUser;
  }

  // this spot we check localstorage and setting current user
  setCurrentUser(): void {
    const getItem = localStorage.getItem('user');

    if (getItem != null) {
      const user: User = JSON.parse(getItem);
      this.accountService.setCurrentUser(user);
      this.userExist = this.isUserExist();
    } else {
      this.accountService.setCurrentUser(null);
      this.userExist = this.isUserExist();
    }
  }

  // check whether exist role, then redirect to specific component
  setPropertySite(userRoles: string): void {
    const url = this.accountService.roles[userRoles];
    if (url) { this.router.navigateByUrl(url); }
  }
}
