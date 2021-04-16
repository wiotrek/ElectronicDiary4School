import { Component, OnInit } from '@angular/core';
import { Location } from '@angular/common';
import { Dictionary } from 'src/app/_models/dictionary';

@Component({
  selector: 'app-present-list',
  templateUrl: './present-list.component.html',
  styleUrls: ['./present-list.component.css']
})
export class PresentListComponent implements OnInit {
  title = 'Lista obecności';
  selectedDate: any;
  today: Date;

  studentsList: Dictionary<string, string>[] = [
    {key: 'Agnieszka', value: 'Antczak'},
    {key: 'Marek', value: 'Fujara'},
    {key: 'Grzegorz', value: 'Ordan'},
    {key: 'Patrycja', value: 'Nowak'}
  ];

  constructor(private location: Location) {
    this.today = new Date();
   }

  ngOnInit(): void {
  }

  back = () => this.location.back();

}
