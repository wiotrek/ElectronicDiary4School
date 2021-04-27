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
  editModeForIndex = -1;
  list = [
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
    {name: 'Piotr', lastname: 'Dupa', marks: [1, 2, 3, 4, 5, 6, 3]},
  ];

  constructor() { }

  ngOnInit(): void {
  }

  editModeToggle(ind: number): void {
    this.editModeForIndex === ind
    ? this.editModeForIndex = -1
    : this.editModeForIndex = ind;
  }

}
