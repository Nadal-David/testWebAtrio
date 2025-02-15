import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import { PersonneService } from '../../services/personne.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Personne} from '../../models/personne.model';
import { EmploiService} from '../../services/emplois.service';
import {CommonModule} from '@angular/common';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatSelectModule} from '@angular/material/select';
import {MatDatepickerModule} from '@angular/material/datepicker';
import {MatButtonModule} from '@angular/material/button';
import {MatInputModule} from '@angular/material/input';
import {provideNativeDateAdapter} from '@angular/material/core';

@Component({
  selector: 'app-add-emploi',
  templateUrl: './addEmplois.component.html',
  standalone: true,
  providers: [provideNativeDateAdapter()],
  imports: [
    CommonModule,
    ReactiveFormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    MatDatepickerModule,
    MatButtonModule
  ],
  styleUrls: ['./addEmplois.component.scss']
})
export class AddEmploisComponent implements OnInit {
  emploisForm!: FormGroup;
  personnes: Personne[] = [];
  maxDate: Date = new Date();
  minDate: Date = new Date();

  constructor(
    private fb: FormBuilder,
    private personneService: PersonneService,
    private emploiService: EmploiService,
    private snackBar: MatSnackBar
  ) {}

  ngOnInit(): void {
    this.maxDate = new Date();
    const currentYear = new Date().getFullYear();
    const minYear = currentYear - 150;
    this.minDate = new Date(new Date().setFullYear(minYear));

    this.emploisForm = this.fb.group({
      personne: ['', Validators.required],
      nomEntreprise: ['', Validators.required],
      poste: ['', Validators.required],
      dateDebut: ['', Validators.required],
      dateFin: ['']
    });

    this.getPersonnes();
  }

  getPersonnes(): void {
    this.personneService.getPersonnes().subscribe({
      next: (data) => {
        this.personnes = data;
      },
      error: (error) => {
        console.error('Erreur lors de la récupération des personnes', error);
      }
    });
  }

  submitForm(): void {
    if (this.emploisForm.valid) {
      const formData = this.emploisForm.value;
      const personneId = formData.personne;

      this.emploiService.addEmploi(personneId, formData).subscribe({
        next: (response) => {
          this.snackBar.open(response.message, 'Fermer', {
            duration: 3000,
          });

          this.emploisForm.reset();
        },
        error: (error) => {
          this.snackBar.open(error.error.message, 'Fermer', {
            duration: 3000,
          });
        }
      });
    } else {
      console.log('Formulaire invalide');
    }
  }
}
