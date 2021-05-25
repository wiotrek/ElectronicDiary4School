import { Component, OnInit, ViewChild } from '@angular/core';
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

  constructor() {
    this.teachersObj = this.teachers();
    this.kindOfObj = this.kindof();
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

  kindof = () => [
    'Ogłoszenie', 'Uwaga', 'Ogólna wiadomość'
  ]

}
