import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';

@Component({
  selector: 'app-present-list',
  templateUrl: './present-list.component.html',
  styleUrls: ['./present-list.component.css']
})
export class PresentListComponent implements OnInit {
  title = 'Lista obecności';

  constructor(
    private location: Location
  ) { }

  ngOnInit(): void {
  }

  back = () => this.location.back();

}
