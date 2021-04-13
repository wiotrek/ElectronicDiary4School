import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { NgbDropdown, NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { JwtModule } from '@auth0/angular-jwt';
import { HttpClientModule } from '@angular/common/http';
import { environment } from 'src/environments/environment';

// tslint:disable-next-line: typedef
export function tokenGetter() {
  return localStorage.getItem('user');
}

@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    FormsModule,
    HttpClientModule,
    JwtModule.forRoot({
      config: {
        tokenGetter,
        allowedDomains: [environment.url],
        disallowedRoutes: [''],
      },
    }),
  ],
  exports: [
    FormsModule,
    NgbModule
  ],
  providers: [
    NgbDropdown
  ]
})
export class SharedModule { }
