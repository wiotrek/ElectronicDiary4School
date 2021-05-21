import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { User } from '../_models/user';
import { AccountService } from '../_services/account.service';

@Injectable({
  providedIn: 'root'
})
export class ParentGuard implements CanActivate {
  constructor(private accountService: AccountService){}

  canActivate(): Observable<boolean> {
    return this.accountService.currentUser$.pipe(
      map((user: User | null) => !!user?.role.includes('Rodzic'))); }
}
