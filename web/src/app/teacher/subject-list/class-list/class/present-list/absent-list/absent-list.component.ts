import { Component, Input, OnInit } from '@angular/core';
import { Student } from 'src/app/_models/_teacher/student';

@Component({
  selector: 'app-absent-list',
  templateUrl: './absent-list.component.html',
  styleUrls: ['./absent-list.component.css']
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
