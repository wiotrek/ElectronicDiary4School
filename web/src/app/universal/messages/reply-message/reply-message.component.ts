import { Component, Input, OnInit } from '@angular/core';
import { ReadMessage } from 'src/app/_models/_messages/read-message';

@Component({
  selector: 'app-reply-message',
  templateUrl: './reply-message.component.html',
  styleUrls: ['./reply-message.component.css']
})
export class ReplyMessageComponent implements OnInit {
  @Input() reciver = {} as ReadMessage;

  constructor() { }

  ngOnInit(): void {
  }

}
