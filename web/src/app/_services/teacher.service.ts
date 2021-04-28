import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { StudentsMarks } from '../_models/models_teacher/students-marks';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class TeacherService {
  baseUrl = environment.apiUrl;

  constructor(private http: HttpClient) { }

  // TODO: definetly the name change is needed
  delDashesAndUpperFirstLetter(getSubject: string): string {
    let subject = getSubject.charAt(0).toUpperCase() + getSubject.slice(1);
    return subject = subject.replace(/-/g, ' ');
  }

  // TODO: change all types on types from interfaces
  getSubjects(): any {
    return this.http.get(this.baseUrl + 'teacher/subjects');
  }

  getClasses(subjectName: string): any {
    return this.http.get(this.baseUrl + `teacher/subject=${subjectName}/classes`);
  }

  getStudents(className: string): any {
    return this.http.get(this.baseUrl + `students/class=${className}`);
  }

  sendPresentList(subject: string, date: string, students: string[]): any {
    return this.http.post(this.baseUrl + `student-active/${subject}/${date}`, students);
  }

  getStudentsMarks(subject: string, className: string): Observable<StudentsMarks[]> {
    const path = `teacher/subject=${subject}/class=${className}/marks`;
    return this.http.get<StudentsMarks[]>(this.baseUrl + path);
  }

}
