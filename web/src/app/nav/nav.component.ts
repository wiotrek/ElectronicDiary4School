import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent implements OnInit {

  constructor() { }

  ngOnInit(): void {
  }

  person = {
    name: 'Sylwia',
    photoUrl: 'https://randomuser.me/api/portraits/women/60.jpg'
  };

}
