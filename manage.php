<?php

define('MATCHES_FILE_PATH', './matches.csv'); //yes, it's a dup
// $_PSOT
// match-date: (string) ""
// home-team: (string) "$team"
// home-team-unlisted: (string) ""
// home-team-goals: (string) ""
// away-team: (string) "$team"
// away-team-unlisted: (string) ""
// away-team-goals: (string) ""

function appendToCsv(array $array, string $csvPath)
{
	$handle = fopen($csvPath, 'a');
	fputcsv($handle, $array);
	fclose($csvPath);
}

if (isset($_POST['action']) && isset($_POST['resource'])) {
	if ($_POST['action'] === 'store' && $_POST['resource'] === 'match') {

		$homeTeam = $_POST['home-team-unlisted'] === '' ? $_POST['home-team'] :$_POST['home-team-unlisted'];
		$awayTeam = $_POST['away-team-unlisted'] === '' ? $_POST['away-team'] : $_POST['away-team-unlisted'];

		$match = [$_POST['match-date'], $homeTeam , $_POST['home-team-goals'], $_POST['away-team-goals'], $awayTeam];
		appendToCsv($match, MATCHES_FILE_PATH);
	}
};
header('location: ./index.php');
exit;