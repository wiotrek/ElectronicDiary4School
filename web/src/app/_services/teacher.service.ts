import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Observable, of } from 'rxjs';
import { StudentsMarks } from '../_models/models_teacher/students-marks';
import { ListToCard } from '../_models/list-to-card';
import { StudentPresentList } from '../_models/models_teacher/student-present-list';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class TeacherService {
  baseUrl = environment.apiUrl;
  listOfSubject: ListToCard[] = [];
  listOfClassCache = new Map();

  constructor(private http: HttpClient) { }

  delDashesAndUpperFirstLetter(getSubject: string): string {
    const subject = getSubject.charAt(0).toUpperCase() + getSubject.slice(1);
    return subject.replace(/-/g, ' ');
  }

  // if early user got list of subject then this list is in cache
  getSubjects(): Observable<ListToCard[]> {
    if (this.listOfSubject.length >  0) { return of(this.listOfSubject); }
    return this.http.get<ListToCard[]>(this.baseUrl + 'teacher/subjects').pipe(
      map(subjects => {
        this.listOfSubject = subjects;
        return subjects;
      })
    );
  }

  getClasses(subjectName: string): Observable<ListToCard[]> {

    // getting object about name subjectName
    const response = this.listOfClassCache.get(Object.values(subjectName).join('-'));

    // check out this object in listOfClassCache if exist, then return him
    if (response) { return of (response); }

    const path = `teacher/subject=${subjectName}/classes`;
    return this.http.get<ListToCard[]>(this.baseUrl + path).pipe(
      map(classes => {
        this.listOfClassCache.set(Object.values(subjectName).join('-'), classes);
        return classes;
      })
    );
  }

  getStudents(className: string): Observable<StudentPresentList[]> {
    const path = `students/class=${className}`;
    return this.http.get<StudentPresentList[]>(this.baseUrl + path);
  }

  sendPresentList(subject: string, date: string, students: string[]): any {
    const path = `student-active/${subject}/${date}`;
    return this.http.post(this.baseUrl + path, students);
  }

  getStudentsMarks(subject: string, className: string): Observable<StudentsMarks[]> {
    const path = `teacher/subject=${subject}/class=${className}/marks`;
    return this.http.get<StudentsMarks[]>(this.baseUrl + path);
  }

}
