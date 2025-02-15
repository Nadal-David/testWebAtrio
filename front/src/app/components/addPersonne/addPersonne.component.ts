import {Component, OnInit,} from '@angular/core';
import {FormBuilder, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {MatFormFieldModule} from '@angular/material/form-field';
import {MatButtonModule} from '@angular/material/button';
import {MatInputModule} from '@angular/material/input';
import {NgIf} from '@angular/common';
import {MatDatepickerModule} from '@angular/material/datepicker';
import {provideNativeDateAdapter} from '@angular/material/core';
import {PersonneService} from '../../services/personne.service';
import {MatSnackBar} from '@angular/material/snack-bar';

@Component({
  selector: 'app-add-personne',
  templateUrl: './addPersonne.component.html',
  standalone: true,
  providers: [provideNativeDateAdapter()],
  imports: [
    MatFormFieldModule,
    ReactiveFormsModule,
    MatButtonModule,
    MatInputModule,
    NgIf,
    MatDatepickerModule,
  ],
  styleUrls: ['./addPersonne.component.scss']
})
export class AddPersonneComponent implements OnInit {
  personneForm!: FormGroup;
  maxDate: Date = new Date();
  minDate: Date = new Date();


  constructor(private fb: FormBuilder, private personneService: PersonneService, private snackBar: MatSnackBar) {
  }

  ngOnInit(): void {
    this.maxDate = new Date();

    const currentYear = new Date().getFullYear();
    const minYear = currentYear - 150;
    this.minDate = new Date(new Date().setFullYear(minYear));

    this.personneForm = this.fb.group({
      nom: ['', Validators.required],
      prenom: ['', Validators.required],
      dateNaissance: ['', Validators.required]
    });
  }

  submitForm(): void {
    if (this.personneForm.valid) {
      const formData = this.personneForm.value;

      this.personneService.addPersonne(formData).subscribe({
        next: (response) => {
          this.snackBar.open(response.message, 'Fermer', {
            duration: 3000,
          });

          this.personneForm.reset({
            nom: '',
            prenom: '',
            dateNaissance: ''
          });
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
