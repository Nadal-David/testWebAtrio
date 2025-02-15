import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import {Personne} from '../models/personne.model';

@Injectable({
  providedIn: 'root',
})
export class PersonneService {
  private apiUrl = 'http://localhost:8080/api/personne';

  constructor(private http: HttpClient) {}

  addPersonne(personneData: any): Observable<any> {
    return this.http.post(`${this.apiUrl}/new`, personneData);
  }

  getPersonnes(): Observable<Personne[]> {
    return this.http.get<Personne[]>(`${this.apiUrl}/all`);
  }
}
