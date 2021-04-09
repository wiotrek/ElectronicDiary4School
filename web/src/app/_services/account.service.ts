import { Injectable } from '@angular/core';
import { ReplaySubject } from 'rxjs';
import { User } from '../_models/user';

@Injectable({
  providedIn: 'root'
})
export class AccountService {

  private currentUserSource = new ReplaySubject<User | null>(1);
  currentUser$ = this.currentUserSource.asObservable();

  constructor() { }

  login(model: any): any{

    if (!(model.username === 'a' && model.password === 'a')) {
      return 'Nie udalo sie';
    }

    const logedUser: User = {username: 'Sylwia', token: 'dlugitoken123'};
    this.setCurrentUser(logedUser);
    window.location.reload();
  }

  setCurrentUser(user: User | null): void {
    localStorage.setItem('user', JSON.stringify(user));
    this.currentUserSource.next(user);
  }

  logout(): void {
    localStorage.removeItem('user');
    this.currentUserSource.next(null);
  }

}
