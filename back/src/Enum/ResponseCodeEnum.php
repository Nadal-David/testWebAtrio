<?php

namespace App\Enum;

enum ResponseCodeEnum: string
{
    public const MISSING_PARAMETERS = 'MISSING_PARAMETERS';
    public const POST_INVALID_DATA = 'POST_INVALID_DATA';
    public const ENTITY_INVALID_DATA = 'ENTITY_INVALID_DATA';
    public const NEW_PERSONNE_SUCCES = 'NEW_PERSONNE_SUCCES';
    public const MAX_AGE = 'MAX_AGE';
    public const DATE_FORMAT = 'DATE_FORMAT';
    public const PERSONNE_NOT_FOUND = 'PERSONNE_NOT_FOUND';
    public const ADD_EMPLOI_SUCCES = 'ADD_EMPLOI_SUCCES';

}