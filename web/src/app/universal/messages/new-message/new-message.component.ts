import { Component, OnInit } from '@angular/core';
import { AccountService } from 'src/app/_services/account.service';

@Component({
  selector: 'app-new-message',
  templateUrl: './new-message.component.html',
  styleUrls: ['./new-message.component.css']
})
export class NewMessageComponent implements OnInit {
  teachersObj;
  kindOfObj;
  toNav = { title: 'Nowa wiadomość'};

  constructor(
    private acccountService: AccountService
  ) {
    this.teachersObj = this.teachers();
    this.kindOfObj = this.kindof();
  }

  ngOnInit(): void {
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
