import { Injectable } from '@angular/core';
import { ReplaySubject } from 'rxjs';
import { environment } from 'src/environments/environment';
import { User } from '../_models/user';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class AccountService {
  private currentUserSource = new ReplaySubject<User | null>(1);
  currentUser$ = this.currentUserSource.asObservable();
  baseUrl = environment.apiUrl;

  roles = [
    {teacher: '/nauczyciel'},
    {student: '/uczen'}
  ];

  constructor(private http: HttpClient) { }
  // login(model: any): any{

  //   if (!(model.idenifier === 'a' && model.password === 'a')) {
  //     return 'Nie udalo sie';
  //   }

  //   const logedUser: User = {username: 'Sylwia', token: 'dlugitoken123', roles: ['teacher']};
  //   this.setCurrentUser(logedUser);
  //   window.location.reload();
  // }

  login(model: any): any{
    return this.http.post(this.baseUrl + 'logowanie', model).pipe(
       map((response) => {
         const t = this.getDecodedToken(response);
         const user = response as User;
         if (user){
           this.setCurrentUser(user);
         }
       })
    );
  }


  setCurrentUser(user: User | null): void{
    if (user){
      user.roles = [];
      const roles = this.getDecodedToken(user.token).role;
      Array.isArray(roles) ? user.roles = roles : user.roles.push(roles);
    }
    // doesnt matter whether user is null or not
    // adding property to func next is really important
    localStorage.setItem('user', JSON.stringify(user));
    this.currentUserSource.next(user);
  }

  logout(): void {
    localStorage.removeItem('user');
    this.currentUserSource.next(null);
  }

  getDecodedToken(token: any): any {
    return JSON.parse(atob(token.split('.')[1]));
  }
}
