import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-new-message',
  templateUrl: './new-message.component.html',
  styleUrls: ['./new-message.component.css']
})
export class NewMessageComponent implements OnInit {
  toNav = { title: 'Nowa wiadomość'};
  subject = '';

  teachersObj;
  kindOfObj;
  listOfClass: string[];

  constructor() {
    this.teachersObj = this.teachers();
    this.kindOfObj = this.kindof();
    this.listOfClass = this.students().reduce((total: string[], curr: any): string[] => {
      total.push(curr.class);
      return [...new Set(total)];
    }, []);

    console.log(this.listOfClass);
  }

  ngOnInit(): void {
  }

  onSubmit(message: NgForm): void {
    console.log(message.value);
  }

  teachers = () => [
    {
      teacherName: 'Ewa Chodakowska',
      subjectName: 'Muzyka',
    },
    {
      teacherName: 'Halina Torzewska',
      subjectName: 'Matematyka',
    },
    {
      teacherName: 'Edmunt Kanciastroporty',
      subjectName: 'Wychowanie fizyczne',
    },
    {
      teacherName: 'Zofia Kowalewska',
      subjectName: 'Język Angielski',
    }
  ]

  students = () => [
    {
      class: '4a',
      name: 'Krystian',
      lastName: 'Kowlaski'
    },
    {
      class: '4b',
      name: 'Krystian',
      lastName: 'Wieczorek'
    },
    {
      class: '4b',
      name: 'Łukasz',
      lastName: 'Dworek'
    },
    {
      class: '5a',
      name: 'Krystian',
      lastName: 'Wieczorek'
    },
    {
      class: '4a',
      name: 'Krystian',
      lastName: 'Wieczorek'
    },
  ]


  kindof = () => [
    'Ogłoszenie', 'Uwaga', 'Ogólna wiadomość'
  ]

}
