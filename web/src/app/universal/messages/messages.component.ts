import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-messages',
  templateUrl: './messages.component.html',
  styleUrls: ['./messages.component.css']
})
export class MessagesComponent implements OnInit {
  nav = { title: 'Powiadomienia' };
  wholeMessageMode = -1;

  messagesStart = 0;
  messagesEnd = 5;

  sendersObj;

  constructor() {
    this.sendersObj = this.senders();
    for (let index = 0; index < 5; index++) {
      this.senders().forEach(x => this.sendersObj.push(x));
    }
   }

  ngOnInit(): void {
  }

  wholeMessageModeToggle(ind: number): void {
    this.wholeMessageMode === ind
    ? this.wholeMessageMode = -1
    : this.wholeMessageMode = ind;
  }

  paginationOwn = (next: boolean) => {
    if (next) {
      this.messagesStart += 5;
      this.messagesEnd += 5;
    } else {
      this.messagesStart -= 5;
      this.messagesEnd -= 5;
    }
  }

  senders = () => [
    {
      avatar: 'https://randomuser.me/api/portraits/lego/2.jpg',
      name: 'Marek Jóźwiak',
      date: '2021-03-03',
      sender: true,
      read: false,
      subject: 'Język polski',
      message: 'dzien dobry mam wazna wiadomosc dsaijdoi aosdjioasdj oasidjiasd asdos'
    },
    {
      avatar: 'https://randomuser.me/api/portraits/lego/1.jpg',
      name: 'Marek Jóźwiak',
      date: '2021-03-03',
      sender: true,
      read: false,
      subject: 'Język Polski',
      message: 'Witam szanowny panie'
    },
    {
      avatar: 'https://randomuser.me/api/portraits/lego/1.jpg',
      name: 'Bartek Majowy',
      date: '2021-03-03',
      sender: false,
      read: true,
      subject: 'Język Polski',
      message: 'Witam szanowny panie'
    }
  ]
}
