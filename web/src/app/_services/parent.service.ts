import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { TeacherWithSubject } from '../_models/_parent/teachers-list';

@Injectable({
  providedIn: 'root'
})
export class ParentService {
  baseUrl = environment.apiUrl;
  teachersList: TeacherWithSubject[] = [];

  constructor(private http: HttpClient) { }

  getTeacherList(): Observable<TeacherWithSubject[]> {
    if (this.teachersList.length >  0) { return of(this.teachersList); }
    return this.http.get<TeacherWithSubject[]>(this.baseUrl + 'parent/teacher-list').pipe(
      map(teacher => {
        this.teachersList = teacher;
        return teacher;
      })
    );
  }

}
