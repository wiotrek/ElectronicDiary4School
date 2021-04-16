import { Component } from '@angular/core';
import { Dictionary } from 'src/app/_models/dictionary';

@Component({
  selector: 'app-not-found',
  template: `
  <div class="container">
    <h1>Nie znaleziono strony<i class="bi bi-emoji-frown"></i></h1>
    <button class="btn btn-primary" routerLink='/'>Wróć do strony głównej</button>
    <h2>lub wróć do:</h2>
    <button class="btn btn-info" *ngFor="let site of sites" routerLink="{{site.value}}">
      Wróć do strony {{site.key}}</button>
  </div>`,
  styles: [
     '.container * {margin: 10px;}',
  ]
})
export class NotFoundComponent {
  sites: Dictionary<string, string>[] = [
    {key: 'nauczyciela', value: '/nauczyciel'},
    {key: 'ucznia', value: '/uczen'},
    {key: 'rodzica', value: '/rodzic'}
  ];
  constructor(){}
}
