import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class EmploiService {

  private apiUrl = 'http://localhost:8080/api/emploi/add';

  constructor(private http: HttpClient) {}

  addEmploi(personneId: number, emploiData: any): Observable<any> {
    const url = `${this.apiUrl}/${personneId}`;
    return this.http.post<any>(url, emploiData);
  }
}
