import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ReplaySubject } from 'rxjs';
import { User } from '../_models/user';

@Injectable({
  providedIn: 'root'
})
export class AccountService {

  private currentUserSource = new ReplaySubject<User | null>(1);
  currentUser$ = this.currentUserSource.asObservable();

  constructor(
    private http: HttpClient
  ) { }
}
