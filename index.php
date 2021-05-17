<?php
require('./configs/dbconnection.php');
require('./configs/config.php');

require('./utils/standings.php');

require('./models/team.php');
require('./models/match.php');

use function Match\all as allMatches;
use function Match\allWithTeams as allMatchesWithTeams;
use function Match\allWithTeamsGrouped as allWithTeamsGrouped;
use function Team\all as allTeams;

$connection = getConnection();
$teams = allTeams($connection);
$matches = allWithTeamsGrouped(allMatchesWithTeams($connection));


$standing = [];
foreach ($matches as $match){
	$homeTeam = $match->home_team;
	$awayTeam = $match->away_team;

	if (!array_key_exists($homeTeam, $standing)) {
		$standing[$homeTeam] = initEmptyStatsArray(); // create index $hometeam and fill it this array
	};
	if (!array_key_exists($awayTeam, $standing)) {
		$standing[$awayTeam] = initEmptyStatsArray();
	};
	$standing[$homeTeam]['games']++;
	$standing[$awayTeam]['games']++;

	// draws //
	if ($match->home_team_goals === $match->away_team_goals) {
		$standing[$homeTeam]['score']++;
		$standing[$awayTeam]['score']++;
		$standing[$homeTeam]['draws']++;
		$standing[$awayTeam]['draws']++;

		// home wins //
	} elseif ($match->home_team_goals > $match->away_team_goals) {
		$standing[$homeTeam]['score'] += 3;
		$standing[$homeTeam]['wins']++;
		$standing[$awayTeam]['losses']++;

		// home losses //
	} else {
		$standing[$awayTeam]['score'] += 3;
		$standing[$awayTeam]['wins']++;
		$standing[$homeTeam]['losses']++;
	};

	// goals comparisons //
	$standing[$homeTeam]['GF'] += $match->home_team_goals;
	$standing[$awayTeam]['GF'] += $match->away_team_goals;
	$standing[$homeTeam]['GA'] += $match->away_team_goals;
	$standing[$awayTeam]['GA'] += $match->home_team_goals;
	$standing[$homeTeam]['GD'] = $standing[$homeTeam]['GF'] - $standing[$homeTeam]['GA'];
	$standing[$awayTeam]['GD'] = $standing[$awayTeam]['GF'] - $standing[$awayTeam]['GA'];
}

uasort($standing, function ($a, $b) {
	if ($a['score'] === $b['score']) {
		return 0;
	};
	return $a['score'] > $b['score'] ? -1 : 1;
});

$teams = array_keys($standing);
sort($teams);

include('./views/vue.php');
