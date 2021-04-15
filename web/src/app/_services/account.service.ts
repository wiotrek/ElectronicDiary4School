import { Injectable } from '@angular/core';
import { ReplaySubject } from 'rxjs';
import { environment } from 'src/environments/environment';
import { User } from '../_models/user';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { DictionaryList } from '../_models/dictionary-list';

@Injectable({
  providedIn: 'root'
})
export class AccountService {
  private currentUserSource = new ReplaySubject<User | null>(1);
  currentUser$ = this.currentUserSource.asObservable();
  baseUrl = environment.apiUrl;

  // Why we have a 2 dictionary? because way dictionarylist sorting
  // alphabetically list
  roles: DictionaryList<string> = {
    teacher: '/nauczyciel',
    student: '/uczen',
  };

  constructor(private http: HttpClient) { }

  login(model: any): any {
    return this.http.post(this.baseUrl + 'logowanie', model).pipe(
      map((res) => {
        const user = res as User;
        this.setCurrentUser(user);
      })
    );
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
