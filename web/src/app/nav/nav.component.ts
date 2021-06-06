import { Component } from '@angular/core';
import { DictionaryList } from '../_models/dictionary-list';
import { AccountService } from '../_services/account.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent {
  darkMode = false;

  darkModeListColor: DictionaryList<string> =  {
    '--primary-blue': '#20B2AA',
    '--primary-grey': '#708090',
    '--line-grey': '#B0C4DE',
    '--primary-white': '#B0C4DE',
    '--text-black': '#E0FFFF'
  };

  lightModeListColor: DictionaryList<string> = {
    '--primary-blue': '#2D9CDB',
    '--primary-grey': '#F7F8FC',
    '--line-grey': '#DFE0EB',
    '--primary-white': '#FFFFFF',
    '--text-black': '#000000'
  };

  constructor(public accountService: AccountService) { }

  logout(): void {
    this.accountService.logout();
    window.location.reload();
  }

  // toggle dark mode on light mode and reverse
  darkmodeToggle = () => {
    this.darkMode
    ? Object.keys(this.darkModeListColor).forEach(property => {
        document.documentElement.style
          .setProperty(property, this.darkModeListColor[property]);  })
    : Object.keys(this.lightModeListColor).forEach(property => {
      document.documentElement.style
        .setProperty(property, this.lightModeListColor[property]); });
  }
}
