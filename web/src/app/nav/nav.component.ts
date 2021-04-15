import { Component } from '@angular/core';
import { AccountService } from '../_services/account.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent {

  constructor(public accountService: AccountService) { }

  logout(): void {
    this.accountService.logout();
    window.location.reload();
  }
}
