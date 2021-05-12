import { Component, Input } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Card } from 'src/app/_models/_universal/card';

@Component({
  selector: 'app-card',
  templateUrl: './card.component.html',
  styleUrls: ['./card.component.css']
})
export class CardComponent {
  @Input() dateCard = {} as Card;
  @Input() colorCard: string;

  constructor(
    private router: Router,
    private route: ActivatedRoute) { this.colorCard = '#F4A460'; }

  // function which redirect to specific place, if setting click mode
  routerlink = () => {
    if (this.dateCard.readonly) { return; }
    const url = this.dateCard.description.replace(/\s+/g, '-').toLowerCase();
    this.router.navigate([`${url}`], {relativeTo: this.route});
  }
}
