<?php

require('./configs/config.php');
require('./configs/dbconnection.php');

require('./models/team.php');
require('./models/match.php');

use function Match\all as allMatches;
use function Match\allWithTeams as allMatchesWithTeams;
use function Match\allWithTeamsGrouped as allWithTeamsGrouped;
use function Team\all as allTeams;

define('MATCH_DATE', (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('F jS, Y'));

$connection = getConnection();
$teams = allTeams($connection);
$temp = allMatchesWithTeams($connection);
var_dump($temp); exit();
// foreach($temp as $t) {
// 	var_dump($t->id);
// }
exit();
$matches = allWithTeamsGrouped(allMatchesWithTeams($connection));

var_dump($matches); exit();

function initEmptyStatsArray()
{
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

// $matchesHandle = fopen(MATCHES_FILE_PATH, 'r');
// $tableHeaders = fgetcsv($matchesHandle, 1000, ',');

// while ($tableLine = fgetcsv($matchesHandle, 1000, ',')) {
// 	$match = array_combine($tableHeaders, $tableLine); // ceci est le match courant
// 	$matches[] = $match;
// 	$homeTeam = $match['home-team'];
// 	$awayTeam = $match['away-team'];
// 	if (!array_key_exists($homeTeam, $standing)) {
// 		$standing[$homeTeam] = initEmptyStatsArray(); // create index $hometeam and fill it this array
// 	};
// 	if (!array_key_exists($awayTeam, $standing)) {
// 		$standing[$awayTeam] = initEmptyStatsArray();
// 	};
// 	$standing[$homeTeam]['games']++;
// 	$standing[$awayTeam]['games']++;

// 	// draws //
// 	if ($match['home-team-goals'] === $match['away-team-goals']) {
// 		$standing[$homeTeam]['score']++;
// 		$standing[$awayTeam]['score']++;
// 		$standing[$homeTeam]['draws']++;
// 		$standing[$awayTeam]['draws']++;

// 		// home wins //
// 	} elseif ($match['home-team-goals'] > $match['away-team-goals']) {
// 		$standing[$homeTeam]['score'] += 3;
// 		$standing[$homeTeam]['wins']++;
// 		$standing[$awayTeam]['losses']++;

// 		// home losses //
// 	} else {
// 		$standing[$awayTeam]['score'] += 3;
// 		$standing[$awayTeam]['wins']++;
// 		$standing[$homeTeam]['losses']++;
// 	};

// 	// goals comparisons //
// 	$standing[$homeTeam]['GF'] += $match['home-team-goals'];
// 	$standing[$awayTeam]['GF'] += $match['away-team-goals'];
// 	$standing[$homeTeam]['GA'] += $match['away-team-goals'];
// 	$standing[$awayTeam]['GA'] += $match['home-team-goals'];
// 	$standing[$homeTeam]['GD'] = $standing[$homeTeam]['GF'] - $standing[$homeTeam]['GA'];
// 	$standing[$awayTeam]['GD'] = $standing[$awayTeam]['GF'] - $standing[$awayTeam]['GA'];
// };

// uasort($standing, function ($a, $b) {
// 	if ($a['score'] === $b['score']) {
// 		return 0;
// 	};
// 	return $a['score'] > $b['score'] ? -1 : 1;
// });

$teams = array_keys($standing);
sort($teams);

include('./views/vue.php');
