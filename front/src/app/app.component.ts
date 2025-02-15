import {Component} from '@angular/core';
import {RouterOutlet} from '@angular/router';
import {MatToolbar} from '@angular/material/toolbar';
import {AddPersonneComponent} from './components/addPersonne/addPersonne.component';
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {AddEmploisComponent} from './components/addEmplois/addEmplois.component';
import {MatButtonModule} from '@angular/material/button';
import {NgIf} from '@angular/common';
import {PersonnesComponent} from './components/Personnes/personnes.component';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, MatToolbar, AddPersonneComponent, MatSnackBarModule, AddEmploisComponent, MatButtonModule, NgIf, PersonnesComponent],
  templateUrl: './app.component.html',
  standalone: true,
  styleUrl: './app.component.scss'
})
export class AppComponent {
  showAddPersonneForm = false;
  showAddEmploisForm = false;
  showListePersonne = false;

  constructor() {
  }

  toggleForm(form: 'personne' | 'emploi' | 'listePersonne'): void {
    if (form === 'personne') {
      this.showAddPersonneForm = !this.showAddPersonneForm;
      this.showAddEmploisForm = false;
      this.showListePersonne = false;
    } else if (form === 'emploi') {
      this.showAddEmploisForm = !this.showAddEmploisForm;
      this.showAddPersonneForm = false;
      this.showListePersonne = false;
    } else if (form === 'listePersonne') {
      this.showListePersonne = !this.showListePersonne;
      this.showAddEmploisForm = false;
      this.showAddPersonneForm = false;
    }
  }
}
