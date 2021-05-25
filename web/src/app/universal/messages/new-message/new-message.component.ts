import { Component, OnInit, ViewChild } from '@angular/core';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-new-message',
  templateUrl: './new-message.component.html',
  styleUrls: ['./new-message.component.css']
})
export class NewMessageComponent implements OnInit {
  @ViewChild('newMessage') newMessage!: NgForm;
  toNav = { title: 'Nowa wiadomość'};

  teachersObj;
  kindOfObj;

  constructor() {
    this.teachersObj = this.teachers();
    this.kindOfObj = this.kindof();
  }

  ngOnInit(): void {
  }

  onSubmit(): void {
    console.log(this.newMessage.value);
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
export interface NewMessage {
  from: string;
  to: string;
  content: string;
  kindof: string;
}