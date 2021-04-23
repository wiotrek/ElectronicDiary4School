import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-marks-list',
  templateUrl: './marks-list.component.html',
  styleUrls: ['./marks-list.component.css']
})
export class MarksListComponent implements OnInit {
  toChild = {
    title: 'Oceny'
  };

  list = [
    {name: 'Piotr', lastname: 'Dupa'},
    {name: 'Piotr', lastname: 'Dupa'},
    {name: 'Piotr', lastname: 'Dupa'},
    {name: 'Piotr', lastname: 'Dupa'},
    {name: 'Piotr', lastname: 'Dupa'},
    {name: 'Piotr', lastname: 'Dupa'},
    {name: 'Piotr', lastname: 'Dupa'},
    {name: 'Piotr', lastname: 'Dupa'},
  ]

  constructor() { }

  ngOnInit(): void {
  }

}
