import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ReadMessage } from 'src/app/_models/_messages/read-message';
import { AccountService } from 'src/app/_services/account.service';

@Component({
  selector: 'app-messages',
  templateUrl: './messages.component.html',
  styleUrls: ['./messages.component.css']
})
export class MessagesComponent implements OnInit {
  nav = { title: 'Powiadomienia' };
  wholeMessageMode = -1;

  page = 0;
  pageSize = 6;
  senderFirst = 0;
  senderLast = 6;

  listOfSenders: ReadMessage[] = [];

  constructor(
    private router: Router,
    private route: ActivatedRoute,
    private accountService: AccountService) {}

  ngOnInit(): void {
    this.accountService.getMessages()
      .subscribe((res: ReadMessage[]) =>  {
        if (res ?? 0) {
          this.listOfSenders = res
          .sort((a: ReadMessage, b: ReadMessage) => Date.parse(b.dateTime) - Date.parse(a.dateTime));
        }
      });
  }

  wholeMessageModeToggle(ind: number): void {
    this.wholeMessageMode === ind
    ? this.wholeMessageMode = -1
    : this.wholeMessageMode = ind;
  }

  goToNewMessage = () => {
    this.router.navigate(['nowa-wiadomość'], { relativeTo: this.route });
  }

  paginationOwn = (next: boolean) => {
    if (next) {
      this.senderFirst += this.pageSize;
      this.senderLast += this.pageSize;
    } else {
      this.senderFirst -= this.pageSize;
      this.senderLast -= this.pageSize;
    }
  }
}
