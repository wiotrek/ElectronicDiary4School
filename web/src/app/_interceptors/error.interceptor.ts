import { Injectable } from '@angular/core';
import {
  HttpRequest,
  HttpHandler,
  HttpEvent,
  HttpInterceptor
} from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { ToastrService } from 'ngx-toastr';
import { catchError } from 'rxjs/operators';
import { Router } from '@angular/router';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {

  constructor(
    private toastr: ToastrService,
    private router: Router) {}

  intercept(request: HttpRequest<unknown>, next: HttpHandler): Observable<HttpEvent<unknown>> {
    return next.handle(request).pipe(
      catchError((err: any) => {
        if (err) {
          switch (err.status) {
            case 400:
              this.toastr.error('Brak danych');
              break;
            case 401:
              this.toastr.error('Brak autoryzacji');
              break;
            case 500:
              this.toastr.error('Wystąpił błąd z serverem');
              this.router.navigate(['not-found']);
              break;

            default:
              this.toastr.error('Wystapił błąd');
          }
        }
        return of(err);
      })
    );
  }
}
