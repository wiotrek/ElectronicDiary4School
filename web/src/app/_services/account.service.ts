import { Injectable } from '@angular/core';
import { Observable, ReplaySubject } from 'rxjs';
import { environment } from 'src/environments/environment';
import { User } from '../_models/user';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs/operators';
import { DictionaryList } from '../_models/dictionary-list';
import { Message } from '../_models/_messages/message';
import { ReadMessage } from '../_models/_messages/read-message';

@Injectable({
  providedIn: 'root'
})
export class AccountService {
  private currentUserSource = new ReplaySubject<User | null>(1);
  currentUser$ = this.currentUserSource.asObservable();
  baseUrl = environment.apiUrl;

  // only for message comopnent
  receivedMessage = {} as ReadMessage[];

  roles: DictionaryList<string> = {
    Nauczyciel: '/nauczyciel',
    Uczeń: '/uczen',
    Rodzic: '/rodzic'
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

  sendMessage(message: Message, addToPath: string): any {
    let path = 'notification/send';
    if (!!addToPath.length) {
      path += addToPath;
    }
    return this.http.post(this.baseUrl + path, message);
  }

  getMessages(): Observable<ReadMessage[]> {
    return this.http.get<ReadMessage[]>(this.baseUrl + 'notification/read');
  }
}
