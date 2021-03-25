<?php

define('MATCHES_FILE_PATH', './matches.csv');

$matches = [];
$matchesHandle = fopen(MATCHES_FILE_PATH, 'r');
$tableHeaders = fgetcsv($matchesHandle, 1000, ',');
while($tableLine = fgetcsv($matchesHandle, 1000, ',')) {
	$matches[] = array_combine($tableHeaders, $tableLine);
};
var_dump($matches); exit();

include('./vue.php'); 