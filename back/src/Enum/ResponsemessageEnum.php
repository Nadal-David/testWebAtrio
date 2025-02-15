<?php

namespace App\Enum;

enum ResponsemessageEnum: string
{
    public const POST_INVALID_DATA = 'Données invalides.';
    public const ENTITY_INVALID_DATA = 'Données entité invalides.';
    public const NEW_PERSONNE_SUCCES = 'Personne ajoutée avec succès.';
    public const MAX_AGE = 'L\'âge ne peut pas être supérieur à 150 ans.';
    public const DATE_FORMAT = 'Format de date invalide, utilisez YYYY-MM-DD.';
    public const MISSING_PARAMETERS = 'Paramètres manquants';
    public const PERSONNE_NOT_FOUND = 'Personne non trouvée';
    public const ADD_EMPLOI_SUCCES = 'Emploi ajouté avec succès.';
}