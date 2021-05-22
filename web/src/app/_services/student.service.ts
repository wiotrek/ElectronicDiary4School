import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, of } from 'rxjs';
import { map } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { Subjects } from '../_models/_student/subjects';
import { Card } from '../_models/_universal/card';

@Injectable({
  providedIn: 'root'
})
export class StudentService {
  baseUrl = environment.apiUrl;

  listOfMarks: Subjects[] = [];
  MarksAvgCache: Card[] = [];

  listOfFrequency: Subjects[] = [];
  frequencyAvgCache: Card[] = [];

  constructor(private http: HttpClient) { }

  // subjects list to student-marks component
  getSubjects(): Observable<Subjects[]> {
    if (this.listOfMarks.length >  0) { return of(this.listOfMarks); }
    return this.http.get<Subjects[]>(this.baseUrl + 'student/subjects/marks').pipe(
      map(subjects => {
        this.listOfMarks = subjects;
        return subjects;
      })
    );
  }

  // subjects list to activity comopnent
  getFrequencies(): Observable<Subjects[]> {
    if (this.listOfFrequency.length >  0) { return of(this.listOfFrequency); }
    return this.http.get<Subjects[]>(this.baseUrl + 'student/subjects/frequencies').pipe(
      map(subjects => {
        this.listOfFrequency = subjects;
        return subjects;
      })
    );
  }

  // get genral avg from all of subjects
  getAvgSubjectMarks(): Observable<Card[]> {
    if (this.MarksAvgCache.length >  0) { return of(this.MarksAvgCache); }
    return this.http.get<Card[]>(this.baseUrl + 'student/marks/average').pipe(
      map(res => {
        this.MarksAvgCache = res;
        return res;
      })
    );
  }

  // get genral avg frequencies from all of subjects
  getAvgSubjectFrequencies(): Observable<Card[]> {
    if (this.frequencyAvgCache.length >  0) { return of(this.frequencyAvgCache); }
    return this.http.get<Card[]>(this.baseUrl + 'student/frequency/average').pipe(
      map(res => {
        this.frequencyAvgCache = res;
        return res;
      })
    );
  }
}
