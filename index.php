<?php
require('./vendor/autoload.php');
require('./configs/dbconnection.php');
require('./configs/config.php');
require('./utils/standings.php');
require('./models/team.php');
require('./models/match.php');

use function Models\Match\all as allMatches;
use function Models\Match\allWithTeams as allMatchesWithTeams;
use function Models\Match\allWithTeamsGrouped as allWithTeamsGrouped;
use function Models\Match\saveToDb as saveMatchToDb;
use function Models\Team\all as allTeams;
use function Models\Team\findById as findTeamById;
use function Models\Team\findByName as findTeamByName;

$connection = getConnection();
$teams = allTeams($connection);
$matches = allWithTeamsGrouped(allMatchesWithTeams($connection));

/*
* A REQUEST IS:
* - a method
* - an action (append, delete)
* - resources (team, match)
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['action']) && isset($_POST['resource'])) {
		if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {
			$homeTeam = findTeamByName($connection, $_POST['home-team']);
			$awayTeam = findTeamByName($connection, $_POST['away-team']);
			$homeTeamGoals = $_POST['home-team-goals'];
			$awayTeamGoals = $_POST['away-team-goals'];

			$match = [
				'date' => $_POST['match-date'],
				'home-team' => $homeTeam->id,
				'home-team-goals' => $homeTeamGoals,
				'away-team-goals' => $awayTeam->id,
				'away-team' => $awayTeamGoals
			];
			saveMatchToDb($connection, $match);
			header('location: ./index.php');
			exit();
		}
	};
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
	if (!isset($_GET['action']) && !isset($_GET['resource'])) {
		$standing = [];
		foreach ($matches as $match) {
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
} else {
	header('locattion: ./index.php');
	exit();
}

include('./views/vue.php');

/*
* manually writing validation branches is "deprecated" in this day and ages,
* frameworks like Laravel and such leverage this important process.
*/