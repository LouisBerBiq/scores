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


/*
* A REQUEST IS:
* - a method
* - an action (append, delete)
* - resources (team, match)
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
	if (isset($_POST['action']) && isset($_POST['resource'])) {
		if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {
			$homeTeam = $_POST['home-team-unlisted'] === '' ? $_POST['home-team'] :$_POST['home-team-unlisted'];
			$awayTeam = $_POST['away-team-unlisted'] === '' ? $_POST['away-team'] : $_POST['away-team-unlisted'];
	
			$match = [$_POST['match-date'], $homeTeam , $_POST['home-team-goals'], $_POST['away-team-goals'], $awayTeam];
			//append to DB
		}
	};
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
	if (!isset($_GET['action']) && !isset($_GET['resource'])){
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
}
} else{
	header('locattion: ./index.php');
	exit();
}

include('./views/vue.php');

/*
* manually writing validation branches is "deprecated" in this day and ages,
* frameworks like Laravel and such leverage this important process.
*/