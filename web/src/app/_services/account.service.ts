import { Injectable } from '@angular/core';
import { ReplaySubject } from 'rxjs';
import { environment } from 'src/environments/environment';
import { User } from '../_models/user';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { JwtHelperService } from '@auth0/angular-jwt';

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

  constructor(
    private http: HttpClient,
    private jwtHelper: JwtHelperService
    ) { }

  login(model: any): any{
    return this.http.post(this.baseUrl + 'logowanie', model).pipe(
       map((res) => {
        //  const user: User = {
        //    identifier: response.message;
        //    t
        //  }
        //  const user = response as User;
        //  if (user){
        //    this.setCurrentUser(user);
        //  }
       })
    );
  }

  setCurrentUser(user: User | null): void{
    // if (user){
    //   user.roles = [];
    //   const roles = this.getDecodedToken(user.token).role;
    //   Array.isArray(roles) ? user.roles = roles : user.roles.push(roles);
    // }
    // doesnt matter whether user is null or not
    // adding property to func next is really important
    localStorage.setItem('user', JSON.stringify(user));
    this.currentUserSource.next(user);
  }

  logout(): void {
    localStorage.removeItem('user');
    this.currentUserSource.next(null);
  }
}
