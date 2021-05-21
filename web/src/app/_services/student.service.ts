import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { Subjects } from '../_models/_student/subjects';

@Injectable({
  providedIn: 'root'
})
export class StudentService {
  baseUrl = environment.apiUrl;

  constructor(private http: HttpClient) { }

  // subjects list to student-marks component
  getSubjects(): Observable<Subjects[]> {
    return this.http.get<Subjects[]>(this.baseUrl + 'student/subjects/marks');
  }

  // subjects list to activity comopnent
  getFrequencies(): Observable<Subjects[]> {
    return this.http.get<Subjects[]>(this.baseUrl + 'student/subjects/frequencies');
  }
}
