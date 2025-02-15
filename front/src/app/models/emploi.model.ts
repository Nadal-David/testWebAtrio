export class Emploi {
  nomEntreprise: string;
  poste: string;
  dateDebut: string;
  dateFin?: string;

  constructor(nomEntreprise: string, poste: string, dateDebut: string, dateFin?: string) {
    this.nomEntreprise = nomEntreprise;
    this.poste = poste;
    this.dateDebut = dateDebut;
    this.dateFin = dateFin;
  }
}
