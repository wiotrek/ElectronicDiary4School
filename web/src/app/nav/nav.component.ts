import { Component, OnInit } from '@angular/core';
import { DictionaryList } from '../_models/dictionary-list';
import { AccountService } from '../_services/account.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent implements OnInit{
  darkMode = false;

  private darkModeListColor: DictionaryList<string> =  {
    '--primary-blue': '#20B2AA',
    '--primary-grey': '#708090',
    '--line-grey': '#B0C4DE',
    '--primary-white': '#B0C4DE',
    '--text-black': '#E0FFFF'
  };

  private lightModeListColor: DictionaryList<string> = {
    '--primary-blue': '#2D9CDB',
    '--primary-grey': '#F7F8FC',
    '--line-grey': '#DFE0EB',
    '--primary-white': '#FFFFFF',
    '--text-black': '#000000'
  };

  constructor(public accountService: AccountService) { }

  ngOnInit(): void {
    this.darkModeIsExist();
  }

  logout(): void {
    this.accountService.logout();
  }

  darkModeIsExist(): void {
    this.darkMode = !!localStorage.getItem('darkMode');

    if (this.darkMode) {
      Object.keys(this.darkModeListColor).forEach(property => {
        document.documentElement.style
          .setProperty(property, this.darkModeListColor[property]);  });
    }
  }

  // toggle dark mode on light mode and reverse
  darkmodeToggle = () => {

    // setting styled
    this.darkMode
    ? Object.keys(this.darkModeListColor).forEach(property => {
        document.documentElement.style
          .setProperty(property, this.darkModeListColor[property]);  })
    : Object.keys(this.lightModeListColor).forEach(property => {
      document.documentElement.style
        .setProperty(property, this.lightModeListColor[property]); });

    // setting local storage
    this.darkMode
    ? localStorage.setItem('darkMode', 'true')
    : localStorage.removeItem('darkMode');
  }
}
