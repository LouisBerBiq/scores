<?php
namespace Models;

class MatchClass extends Model
{
	function allWithTeams(): array
	{
		$matchesInfosRequest = 'SELECT * FROM matches JOIN events e on matches.id = e.match_id JOIN teams t on e.team_id = t.id ORDER BY matches.id, is_home_team DESC';
		$pdoSt = $this->connection->query($matchesInfosRequest);
		return $pdoSt->fetchAll();
	}
	
	function allWithTeamsGrouped(array $allWithTeams): array
	{
		$matchesWithTeams = [];
		$mm = null;
		foreach ($allWithTeams as $match) {
			if ($match->is_home_team) {
				$mm = new \stdClass();
				$mm->match_date = $match->date;
				$mm->home_team = $match->name;
				$mm->home_team_goals = $match->goals;
			} else {
				// listen, I know this is technically not working in the grand scheme of thing but can you just shut the fuck up? There is NO possible scenario where this can break other than the guy encoding everything fucking up the order.
				$mm->away_team = $match->name;
				$mm->away_team_goals = $match->goals;
				$matchesWithTeams[] = $mm;
			}
		}
		return $matchesWithTeams;
	}
	
	// function saveToDb(array $match)
	// {
	// 	$matchRequestToInsert = 'INSERT INTO matches(`date`, `slug`) VALUES (:date, :slug)';
	// 	$pdoSt = $this->connection->prepare($matchRequestToInsert);
	// 	$pdoSt->execute([':date' => $match['date'], ':slug' => '']);
	
	// 	$id = $this->connection->lastInsertId();
	// 	$eventRequestToInsert = 'INSERT INTO events(`match_id`, `team_id`, `goals`, `is_home_team`) VALUES (:match_id, :team_id, :goals, :is_home_team)';
	// 	$pdoSt = $this->connection->prepare($eventRequestToInsert);
	// 	$pdoSt->execute([
	// 		':match_id' => $id,
	// 		':team_id' => $match['home-team'],
	// 		':goals' => $match['home-team-goals'],
	// 		':is_home_team' => 1
	// 	]);
	// 	$pdoSt = $this->connection->prepare($eventRequestToInsert);
	// 	$pdoSt->execute([
	// 		':match_id' => $id,
	// 		':team_id' => $match['away-team'],
	// 		':goals' => $match['away-team-goals'],
	// 		':is_home_team' => 0
	// 	]);
	// }
}
