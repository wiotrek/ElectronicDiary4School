import { Component } from '@angular/core';
import { DictionaryList } from 'src/app/_models/dictionary-list';
import { AccountService } from 'src/app/_services/account.service';

@Component({
  selector: 'app-not-found',
  template: `
  <div class="container">
    <h1>Nie znaleziono strony <i class="bi bi-emoji-frown"></i></h1>
    <button class="btn btn-info" *ngFor="let site of sites | keyvalue"
    routerLink="{{site.value}}">Wróć do sekcji - {{site.key | lowercase}}</button>
  </div>`,
  styles: ['.container * {margin: 10px;}']
})
export class NotFoundComponent {
  sites: DictionaryList<string>;
  constructor(private accountService: AccountService){
    this.sites = this.accountService.roles;
  }
}
