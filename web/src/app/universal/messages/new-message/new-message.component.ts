import { Component, EventEmitter, OnInit, Output } from '@angular/core';
import { NgForm } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { take } from 'rxjs/operators';
import { User } from 'src/app/_models/user';
import { Message } from 'src/app/_models/_messages/message';
import { SendNewMessageAsTeacher } from 'src/app/_models/_messages/send-new-message-as-teacher';
import { TeacherWithSubject } from 'src/app/_models/_parent/teachers-list';
import { StudentsMarks } from 'src/app/_models/_teacher/marks/students-marks';
import { Card } from 'src/app/_models/_universal/card';
import { AccountService } from 'src/app/_services/account.service';
import { ParentService } from 'src/app/_services/parent.service';
import { TeacherService } from 'src/app/_services/teacher.service';


@Component({
  selector: 'app-new-message',
  templateUrl: './new-message.component.html',
  styleUrls: ['../reply&new-message.css']
})
export class NewMessageComponent implements OnInit {
  @Output() refresh = new EventEmitter();
  user = {} as User | null;

  // filled child nav component
  toNav = { title: 'Nowa wiadomość'};

  // creating object only when message sent as teacher
  teacherGroup = {} as SendNewMessageAsTeacher;

  kindOf: string;

  teacher = '';

  // getting objects from subsribe
  listOfSubjects: string[] = [];
  listOfClasses: string[] = [];
  listOfStudents: StudentsMarks[] = [];
  listOfTeachers: TeacherWithSubject[] = [];

  constructor(
    private accountService: AccountService,
    private teacherService: TeacherService,
    private parentService: ParentService,
    private toastr: ToastrService
  ) {

    // setting default true because we want hidding html elements
    // and we dont want unneccessery downloading object
    this.setAllBooleanInObjTrue();

    // fill first list element
    this.kindOf = this.kindof()[0];

    // getting current user role
    this.accountService.currentUser$.pipe(take(1))
      .subscribe(user => this.user = user);
  }

  ngOnInit(): void {
    if (this.user?.role === 'Rodzic') {
      this.parentService.getTeacherList()
      .subscribe((res: TeacherWithSubject[]) => {
        this.listOfTeachers = res;
        this.teacher = this.listOfTeachers[0].identifier;
      });
    }
  }

  getSubjects(): void {
    this.teacherService.getSubjects()
      .subscribe((res: Card[]) => {
        this.listOfSubjects = res.reduce((total: string[], curr: Card): string[] => {
          total.push(curr.name);
          return total; }, []);
        this.teacherGroup.subjectName = this.listOfSubjects[0];
      });
  }

  getClasses(): void {
    this.teacherService.getClasses(this.teacherGroup.subjectName)
      .subscribe((res: Card[]) => {
        this.listOfClasses = res.reduce((total: string[], curr: Card): string[] => {
          total.push(curr.name);
          return total; }, []);
        this.teacherGroup.className = this.listOfClasses[0];
      });
  }

  getStudents(): void {
    this.teacherService.getStudentsMarks(
      this.teacherGroup.subjectName, this.teacherGroup.className)
      .subscribe((res: StudentsMarks[]) =>  {
        this.listOfStudents = res;
        this.teacherGroup.studentName = res[0].student.identifier;
      });
  }

  onSubmit(message: NgForm): void {

    const messageToSend = {} as Message;
    messageToSend.content = message.value.context;
    messageToSend.kindOf = message.value.kindOfMessage;
    messageToSend.sender = this.user?.user.identifier;

    if (!message.value.teacherGroup) {
      messageToSend.receiver = message.value.teacherWithSubjectMessage;
      this.send(messageToSend);
      message.reset();
      this.setAllBooleanInObjTrue();
      return;
    }

    // in teacher case goto this conditions
    let addToPath = '';

    // send to all
    if (message.value.teacherGroup.messageToAll) {
      messageToSend.receiver = 'all';
    }

    // send to all where exist specific subject
    else if (message.value.teacherGroup.messageToAllWhereIsSubject) {
      messageToSend.receiver = 'all';
      addToPath = '/?subject=' + message.value.teacherGroup.subjectMessage;
    }

    // send to specific class
    else if (message.value.teacherGroup.messageToAllWhereIsClass) {
      messageToSend.receiver = message.value.teacherGroup.classMessage;
    }

    // send to spe
    else {
      messageToSend.receiver = message.value.teacherGroup.studentMessage;
    }

    this.send(messageToSend, addToPath);
    message.reset();
    this.setAllBooleanInObjTrue();
  }

  private send(messageToSend: Message, addToPath = ''): void {
    this.accountService.sendMessage(messageToSend, addToPath)
    .subscribe(() => {
      this.toastr.success('Wiadomość wysłana');
      this.refresh.emit(true);
    });
  }

  private setAllBooleanInObjTrue(): void {
    this.teacherGroup.sendToAnyone = true;
    this.teacherGroup.sendToAnyoneWhereIsSubject = true;
    this.teacherGroup.sendToAnyoneWhereIsClass = true;
  }

  // list of type as alert or announcement etc
  kindof = () => [
    'Informacja', 'Ogłoszenie', 'Pytanie', 'Uwaga', 'Wniosek'
  ]
}
