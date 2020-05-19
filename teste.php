<?php

include "vendor/autoload.php";

$tam = new App\AdapterTam('TAM.json');
$tap = new App\AdapterTap('TAP.xml');

$sources = [
    $tam->dataToArray(),
    $tap->dataToArray(),
];

// print_r($tap->dataToArray());

$t = new App\Repository\Flight($sources);

print_r($t->loadData());

