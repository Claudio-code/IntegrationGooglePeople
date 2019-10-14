<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../vendor/autoload.php");
use Api\peopleIntegration\GooglePeoPleIntegration;

$people = new GooglePeoPleIntegration();

// metodo que faz a chamada da tela de url
// echo($people->generateUrlConsentScreen()); 

// pega o code e gera no backend o refresh_token e salva no banco 
// $people->salveToken('4/sAEi8F2t3_Rdp8VmQUrvJk6LytINO2a1CcRccKNaGHAeIl7vdkvwCVE');

// cria um contato no google Contact
print_r($people->createContact("name_lead", 'lead@email.com', '419998252839'));