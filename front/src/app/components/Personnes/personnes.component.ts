import { Component, OnInit } from '@angular/core';
import { PersonneService} from '../../services/personne.service';
import { Personne} from '../../models/personne.model';
import {MatTableModule} from '@angular/material/table';
import {MatButtonModule} from '@angular/material/button';
import {MatPaginatorModule} from '@angular/material/paginator';
import {MatSortModule} from '@angular/material/sort';
import {DatePipe} from '@angular/common';
import {FormsModule} from '@angular/forms';

@Component({
  selector: 'app-personnes',
  templateUrl: './personnes.component.html',
  standalone: true,
  imports: [
    MatTableModule,
    MatButtonModule,
    MatPaginatorModule,
    MatSortModule,
    DatePipe,
    FormsModule,
  ],
  styleUrls: ['./personnes.component.css']
})
export class PersonnesComponent implements OnInit {
  personnes: Personne[] = [];

  constructor(private personneService: PersonneService) {}

  ngOnInit(): void {
    this.personneService.getPersonnes().subscribe((data: Personne[]) => {
      this.personnes = data;
    });
  }
}
