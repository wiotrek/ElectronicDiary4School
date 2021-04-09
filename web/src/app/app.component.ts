import { Component, OnInit } from '@angular/core';
import { User } from './_models/user';
import { AccountService } from './_services/account.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit{
  userExist: boolean;
  title = 'web';

  constructor(private accountService: AccountService)
  { this.userExist = false; }

  ngOnInit(): void {
    this.setCurrentUser();
  }

  isUserExist(): any {
    let isTokenNull;
    this.accountService.currentUser$.subscribe(res => {
      isTokenNull = res?.token === undefined
     || res?.token === null ? true : false;
    });
    // if token is null then user exist so return info about user
    return !isTokenNull;
  }

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
}
