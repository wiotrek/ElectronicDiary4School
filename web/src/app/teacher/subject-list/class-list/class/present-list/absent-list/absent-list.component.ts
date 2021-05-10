import { Component, Input, OnInit } from '@angular/core';
import { Student } from 'src/app/_models/_teacher/student';

@Component({
  selector: 'app-absent-list',
  template: `
  <h2>Studenci którzy byli nieobecni</h2>
    <ul>
        <li class="global-list-element"
        *ngFor="let s of absent">
        <i class="bi bi-bookmark-x" [ngStyle]="{'color': '#ff0000'}"></i>
         {{s.first_name}} {{s.last_name}}
         <span [ngStyle]="{'color': 'var(--primary-blue)'}"> {{s.identifier}}</span></li></ul>

    <h2>Studenci obecni</h2>
    <ul>
        <li class="global-list-element"
        *ngFor="let s of active">
        <i class="bi bi-check2-square" [ngStyle]="{'color': '#008000'}"></i>
        {{s.first_name}} {{s.last_name}}
        <span [ngStyle]="{'color': 'var(--primary-blue)'}"> {{s.identifier}}</span></li></ul>
  `
})
export class AbsentListComponent implements OnInit {
  @Input() getDateFromParent: any;
  absent: Student[] = [];
  active: Student[] = [];
  list = [
    {
      identifier: '213hkl',
      first_name: 'Jarek',
      last_name: 'Kowlaski',
      isActive: false
    },
    {
      identifier: '213hkl',
      first_name: 'Jarek',
      last_name: 'Kowlaski',
      isActive: false
    },
    {
      identifier: '213hkl',
      first_name: 'Jarek',
      last_name: 'Kowlaski',
      isActive: false
    },
    {
      identifier: '213hkl',
      first_name: 'Jarek',
      last_name: 'Kowlaski',
      isActive: false
    },
    {
      identifier: 'dsad2',
      first_name: 'Agata',
      last_name: 'Dumna',
      isActive: true
    },
    {
      identifier: '213hkl',
      first_name: 'Kasia',
      last_name: 'Nowak',
      isActive: true
    }
  ];

  constructor() { }

  ngOnInit(): void {
    this.list.forEach(x => {
      x.isActive ?
      this.active.push(x)
      : this.absent.push(x);
    });
  }

}
