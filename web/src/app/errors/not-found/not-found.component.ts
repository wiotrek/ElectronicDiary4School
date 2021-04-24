import { Component } from '@angular/core';
import { DictionaryList } from 'src/app/_models/dictionary-list';

@Component({
  selector: 'app-not-found',
  template: `
  <div class="container">
    <h1>Nie znaleziono strony <i class="bi bi-emoji-frown"></i></h1>
    <button class="btn btn-info" *ngFor="let site of sites" routerLink="{{site.value}}">
      Wróć do strony {{site.key}}</button>
  </div>`,
  styles: [
     '.container * {margin: 10px;}',
  ]
})
export class NotFoundComponent {
  sites: DictionaryList<string>[] = [
    {key: 'nauczyciela', value: '/nauczyciel'},
    {key: 'ucznia', value: '/uczen'},
    {key: 'rodzica', value: '/rodzic'}
  ];
  constructor(){}
}
