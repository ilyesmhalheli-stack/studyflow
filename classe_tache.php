<?php
// ============================================================
// StudyFlow - Classe Tache
// Auteurs: Med Aziz Gaddour, Mhalheli Ilyes
// Fichier: classe_tache.php
// ENSI 2025/2026 - Partie IV
// ============================================================

class Tache {
    private $id;
    private $utilisateur_id;
    private $titre;
    private $description;
    private $statut;
    private $type;
    private $priorite;
    private $date_limite;
    private $date_travail;
    private $heure_travail;
    private $date_creation;

    public function __construct($id, $utilisateur_id, $titre, $description,
                                $statut, $type, $priorite, $date_limite,
                                $date_travail, $heure_travail, $date_creation = null) {
        $this->id             = $id;
        $this->utilisateur_id = $utilisateur_id;
        $this->titre          = $titre;
        $this->description    = $description;
        $this->statut         = $statut;
        $this->type           = $type;
        $this->priorite       = $priorite;
        $this->date_limite    = $date_limite;
        $this->date_travail   = $date_travail;
        $this->heure_travail  = $heure_travail;
        $this->date_creation  = $date_creation ?: date('Y-m-d H:i:s');
    }

    // Getters
    public function getId()            { return $this->id; }
    public function getUtilisateurId() { return $this->utilisateur_id; }
    public function getTitre()         { return $this->titre; }
    public function getDescription()   { return $this->description; }
    public function getStatut()        { return $this->statut; }
    public function getType()          { return $this->type; }
    public function getPriorite()      { return $this->priorite; }
    public function getDateLimite()    { return $this->date_limite; }
    public function getDateTravail()   { return $this->date_travail; }
    public function getHeureTravail()  { return $this->heure_travail; }
    public function getDateCreation()  { return $this->date_creation; }

    // Setters
    public function setStatut($s)      { $this->statut = $s; }
    public function setPriorite($p)    { $this->priorite = $p; }
    public function setTitre($t)       { $this->titre = $t; }
    public function setDescription($d) { $this->description = $d; }

    // Créer objet depuis tableau BDD
    public static function fromArray($data) {
        return new self(
            $data['id'],
            $data['utilisateur_id'],
            $data['titre'],
            $data['description'],
            $data['statut'],
            $data['type'],
            $data['priorite'],
            $data['date_limite'],
            $data['date_travail'],
            $data['heure_travail'],
            $data['date_creation'] ?? null
        );
    }

    public function getStatutFormatte() {
        $statuts = ['en_attente'=>'En attente','en_cours'=>'En cours','termine'=>'Terminé'];
        return $statuts[$this->statut] ?? $this->statut;
    }

    public function getTypeFormatte() {
        $types = ['examen'=>'Examen','devoir'=>'Devoir','projet'=>'Projet','autre'=>'Autre'];
        return $types[$this->type] ?? $this->type;
    }

    public function getPrioriteFormatte() {
        $priorites = ['haute'=>'Haute','moyenne'=>'Moyenne','basse'=>'Basse'];
        return $priorites[$this->priorite] ?? $this->priorite;
    }

    public function getDateLimiteFormattee() {
        return $this->date_limite ? date('d/m/Y', strtotime($this->date_limite)) : '-';
    }

    public function getDateTravailFormattee() {
        return $this->date_travail ? date('d/m/Y', strtotime($this->date_travail)) : '-';
    }

    public function estEnRetard() {
        return $this->date_limite
            && strtotime($this->date_limite) < time()
            && $this->statut !== 'termine';
    }

    public function getJoursRestants() {
        if (!$this->date_limite) return 0;
        $aujourd_hui = new DateTime();
        $date_limite = new DateTime($this->date_limite);
        return (int)$aujourd_hui->diff($date_limite)->days;
    }

    public function getPrioriteClass() { return 'priority-' . $this->priorite; }
    public function getStatutClass()   { return 'statut-' . $this->statut; }
}
// PAS de fonction ici - seulement la classe !
?>
