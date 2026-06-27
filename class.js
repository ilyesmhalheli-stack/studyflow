class Tache {
    constructor(id, titre, description, statut, date_limite, date_travail, heure_travail) {
        this.id = id;
        this.titre = titre;
        this.description = description;
        this.statut = statut;
        this.date_limite = date_limite;
        this.date_travail = date_travail;
        this.heure_travail = heure_travail;
    }

    getId() { return this.id; }
    getTitre() { return this.titre; }
    getDescription() { return this.description; }
    getStatut() { return this.statut; }
    getDateLimite() { return this.date_limite; }
    getDateTravail() { return this.date_travail; }
    getHeureTravail() { return this.heure_travail; }

    setStatut(s) { this.statut = s; }
}