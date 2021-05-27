import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { take } from 'rxjs/operators';
import { User } from 'src/app/_models/user';
import { Card } from 'src/app/_models/_universal/card';
import { AccountService } from 'src/app/_services/account.service';
import { TeacherService } from 'src/app/_services/teacher.service';

@Component({
  selector: 'app-new-message',
  templateUrl: './new-message.component.html',
  styleUrls: ['./new-message.component.css']
})
export class NewMessageComponent implements OnInit {
  user = {} as User | null;
  toNav = { title: 'Nowa wiadomość'};
  subject = '';
  listOfSubjects = {} as string[];
  sendToAnyOne = true;

  obj = {
    subject: 'Wybierz przedmiot'
  };
  teachersObj;
  kindOfObj;

  constructor(
    private accountService: AccountService,
    private teacherService: TeacherService
  ) {
    this.teachersObj = this.teachers();
    this.kindOfObj = this.kindof();

    this.accountService.currentUser$.pipe(take(1))
      .subscribe(user => this.user = user);
  }

  ngOnInit(): void {

    if (this.user?.role === 'Nauczyciel') {
      this.teacherService.getSubjects()
        .subscribe((res: Card[]) => {
          this.listOfSubjects = res.reduce((total: string[], curr: Card)
          : string[] => {
            total.push(curr.name);
            return total;
          }, []);
        });
    }
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
