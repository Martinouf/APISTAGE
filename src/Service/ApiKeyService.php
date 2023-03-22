<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class ApiKeyService
{
    /**
     * Méthode de vérification
     * @param Request $request
     * @return bool
     */

     public function checkApiKey(Request $request) : bool
    {
        // Vérification de la requête

        //1. Contient le header API-KEY?
        //Attention les Headers HTTP ne peuvent pas avoir de underscore
        $API_KEY = $request->headers->get('API-KEY');

        //Contenu API_KEY
        if($API_KEY)
            $output = true;
        else
            $output = false;

        return $output;
    }
}