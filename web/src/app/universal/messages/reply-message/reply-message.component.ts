import { Component, EventEmitter, Input, Output } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { take } from 'rxjs/operators';
import { User } from 'src/app/_models/user';
import { Message } from 'src/app/_models/_messages/message';
import { ReadMessage } from 'src/app/_models/_messages/read-message';
import { AccountService } from 'src/app/_services/account.service';

@Component({
  selector: 'app-reply-message',
  template: `
  <h2 class="title">Odpowiedz na wiadomość</h2>
  <form #newMessage="ngForm" (ngSubmit)="onSubmit(newMessage)">
      <div class="reciver">
          <select class="reciver__select">
              <option selected>{{reciver.fullName}}</option>
          </select>
      </div>
      <textarea class="textarea-message" cols="30" rows="10"
          name="context" required ngModel></textarea>

      <div class="center-button">
          <input class="btn btn-outline-primary" type="submit" value="Wyślij"
          [disabled]="!newMessage.valid">
      </div>

      <div class="center-button">
          <a class="reply-back" (click)="back.emit(true)">Cofnij</a>
      </div>
  </form>`,
  styleUrls: ['../reply&new-message.css']
})
export class ReplyMessageComponent {
  @Input() reciver = {} as ReadMessage;
  @Output() back = new EventEmitter();
  @Output() refresh = new EventEmitter();

  user = {} as User | null;

  constructor(
    private accountService: AccountService,
    private toastr: ToastrService) {
    this.accountService.currentUser$.pipe(take(1))
      .subscribe(user => this.user = user);
  }

  onSubmit(message: NgForm): void {
    const sendMessage = {} as Message;
    sendMessage.receiver = this.reciver.identifier;
    sendMessage.kindOf = 'Informacja';
    sendMessage.sender = this.user?.user.identifier;
    sendMessage.content = message.value.context;

    this.accountService.sendMessage(sendMessage, '')
    .subscribe(() => {
      this.toastr.success('Wiadomość wysłana');
      this.back.emit(true);
      this.refresh.emit(true);
    });
  }
}
