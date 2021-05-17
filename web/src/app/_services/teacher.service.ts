import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Observable, of } from 'rxjs';
import { StudentsMarks } from '../_models/_teacher/marks/students-marks';
import { map } from 'rxjs/operators';
import { UpdateMark } from '../_models/_teacher/marks/update-marks/update-mark';
import { AddNewMarks } from '../_models/_teacher/marks/new-mark/add-new-marks';
import { StudentActivity } from '../_models/_teacher/activity/student-activity';
import { Card } from '../_models/_universal/card';
import { StudentActivityObj } from '../_models/_teacher/activity/student-activity-obj';

@Injectable({
  providedIn: 'root'
})
export class TeacherService {
  baseUrl = environment.apiUrl;
  listOfSubject: Card[] = [];
  listOfClassCache = new Map();
  listOfStudentsCache = new Map();

  constructor(private http: HttpClient) { }

  delDashesAndUpperFirstLetter(getSubject: string): string {
    const subject = getSubject.charAt(0).toUpperCase() + getSubject.slice(1);
    return subject.replace(/-/g, ' ');
  }

  // if early user got list of subject then this list is in cache
  getSubjects(): Observable<Card[]> {
    if (this.listOfSubject.length >  0) { return of(this.listOfSubject); }
    return this.http.get<Card[]>(this.baseUrl + 'teacher/subjects').pipe(
      map(subjects => {
        this.listOfSubject = subjects;
        return subjects;
      })
    );
  }

  getClasses(subjectName: string): Observable<Card[]> {

    // getting object about name subjectName
    const response = this.listOfClassCache.get(Object.values(subjectName).join('-'));

    // check out this object in listOfClassCache if exist, then return him
    if (response) { return of (response); }

    const path = `teacher/subject=${subjectName}/classes`;
    return this.http.get<Card[]>(this.baseUrl + path).pipe(
      map(classes => {
        this.listOfClassCache.set(Object.values(subjectName).join('-'), classes);
        return classes;
      })
    );
  }

  getStudentsActivity(className: string, subjectName: string, date: string)
  : Observable<StudentActivityObj> {
    const path = `students/class=${className}/subject=${subjectName}/date=${date}`;
    return this.http.get<StudentActivityObj>(this.baseUrl + path);
  }

  sendPresentList(subject: string, students: StudentActivity[]): any {
    const path = `student-active/${subject}`;
    return this.http.put(this.baseUrl + path, students);
  }

  getStudentsMarks(subject: string, className: string, update = false)
  : Observable<StudentsMarks[]> {

    const keyInMap = `${subject} ${className}`;

    if (!update) {
      const response = this.listOfClassCache.get(Object.values(keyInMap).join('-'));
      if (response) { return of (response); }
    }

    const path = `teacher/subject=${subject}/class=${className}/marks`;
    return this.http.get<StudentsMarks[]>(this.baseUrl + path).pipe(
      map(studentsMarks => {
        this.listOfClassCache.set(Object.values(keyInMap).join('-'), studentsMarks);
        return studentsMarks;
      })
    );
  }

  updateStudentMarks(updateMarksList: UpdateMark[]): any {
    const path = 'teacher-marks/edit';
    return this.http.put(this.baseUrl + path, updateMarksList);
  }

  sendNewMark(subject: string, date: string, addNewMarks: AddNewMarks): any {
    const path = `teacher-marks/insert/subject=${subject}/date=${date}`;
    return this.http.post(this.baseUrl + path, addNewMarks);
  }
}
