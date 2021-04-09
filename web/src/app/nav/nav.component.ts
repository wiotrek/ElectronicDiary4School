import { Component } from '@angular/core';
import { AccountService } from '../_services/account.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent {

  constructor(private accountService: AccountService) { }

  person = {
    name: 'Sylwia',
    photoUrl: 'https://randomuser.me/api/portraits/women/60.jpg'
  };

  logout(): void {
    this.accountService.logout();
    window.location.reload();
  }
}
