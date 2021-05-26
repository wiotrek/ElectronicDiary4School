import { Directive, Input, OnInit, TemplateRef, ViewContainerRef } from '@angular/core';
import { take } from 'rxjs/operators';
import { User } from '../_models/user';
import { AccountService } from '../_services/account.service';

@Directive({
  selector: '[appHasRole]'
})
export class HasRoleDirective implements OnInit{
  @Input() appHasRole = {} as string[];
  user = {} as User | null;

  constructor(
    private viewContainerRef: ViewContainerRef,
    private templateRef: TemplateRef<any>,
    private accountService: AccountService) {
      this.accountService.currentUser$.pipe(take(1)).subscribe(user => {
        this.user = user;
      });
    }

  ngOnInit(): void {

    // clear view if no roles
    if (!this.user?.role || this.user == null) {
      this.viewContainerRef.clear();
      return;
    }

    if (this.appHasRole.includes(this.user.role)){
      this.viewContainerRef.createEmbeddedView(this.templateRef);
    } else {
      this.viewContainerRef.clear();
    }
  }
}
