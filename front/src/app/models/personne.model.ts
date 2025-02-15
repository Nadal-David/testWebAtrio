import {Emploi} from './emploi.model';

export class Personne {
  id: number;
  nom: string;
  prenom: string;
  emploisActuels: Emploi[];

  constructor(id: number, nom: string, prenom: string, emploisActuels: Emploi[]) {
    this.id = id;
    this.nom = nom;
    this.prenom = prenom;
    this.emploisActuels = emploisActuels;
  }
}
