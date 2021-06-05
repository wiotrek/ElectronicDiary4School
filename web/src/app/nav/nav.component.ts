import { Component, ElementRef, Renderer2 } from '@angular/core';
import { AccountService } from '../_services/account.service';

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
  styleUrls: ['./nav.component.css']
})
export class NavComponent {
  darkMode = false;

  constructor(
    private elementRef: ElementRef,
    private renderer: Renderer2,
    public accountService: AccountService) { }

  logout(): void {
    this.accountService.logout();
    window.location.reload();
  }

  darkmodeToggle = () => {
    this.renderer.setStyle(this.elementRef.nativeElement.ownerDocument.body,'backgroundColor', 'yourchoice color');
  }
}
