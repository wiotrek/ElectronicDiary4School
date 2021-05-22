import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-messages',
  templateUrl: './messages.component.html',
  styleUrls: ['./messages.component.css']
})
export class MessagesComponent implements OnInit {
  nav = { title: 'Powiadomienia' };
  showSenders = true;

  messagesObj;
  sendersObj;

  constructor() {
    this.sendersObj = this.senders();
    this.messagesObj = this.messages();
   }

  ngOnInit(): void {
  }

  senders = () => [
    {
      name: 'Marek',
      lastname: 'Jóźwiak',
      lastMessage: 'dzien dobry mam wazna wiadomosc dsaijdoi aosdjioasdj oasidjiasd asdos'
    },
    {
      name: 'Jowita',
      lastname: 'Jóźwiak',
      lastMessage: 'dzien dobry mam wazna wiadomosc'
    },
    {
      name: 'Jowita',
      lastname: 'Jóźwiak',
      lastMessage: 'dzien dobry mam wazna wiadomosc'
    },
    {
      name: 'Jowita',
      lastname: 'Jóźwiak',
      lastMessage: 'dzien dobry mam wazna wiadomosc'
    },
    {
      name: 'Jowita',
      lastname: 'Jóźwiak',
      lastMessage: 'dzien dobry mam wazna wiadomosc'
    }
  ]

  messages = () => [
    {
      name: 'Jowita',
      message: 'co tam powiesz mordeczko'
    },
    {
      name: 'Jowita',
      message: 'dawno sie nie odzywałeś'
    },
    {
      name: 'Ty',
      message: 'ano dawno'
    }
  ]



}
