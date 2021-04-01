<?php

define('MATCHES_FILE_PATH', './matches.csv');
define('MATCH_DATE', (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('F jS, Y'));

// final arrays
$matches = [];
$standing = [];

$teams = [];

function initEmptyStatsArray() {
	return [
		'games' => 0,
		'score' => 0,
		'wins' => 0,
		'losses' => 0,
		'draws' => 0,
		'GF' => 0,
		'GA' => 0,
		'GD' => 0,
	];
};

$matchesHandle = fopen(MATCHES_FILE_PATH, 'r');
$tableHeaders = fgetcsv($matchesHandle, 1000, ',');
while($tableLine = fgetcsv($matchesHandle, 1000, ',')) {
	$match = array_combine($tableHeaders, $tableLine);
	$matches[] = $match;
	$homeTeam = $match['home-team'];
	$awayTeam = $match['away-team'];
	if(!array_key_exists($homeTeam, $standing)) {
		$standing[$homeTeam] = initEmptyStatsArray(); // create index $hometeam and fill it this array
	}
	if(!array_key_exists($awayTeam, $standing)) {
		$standing[$awayTeam] = initEmptyStatsArray();
	}
};
var_dump( $standing); exit();

include('./vue.php'); 