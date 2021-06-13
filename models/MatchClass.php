<?php
namespace Models;

use Carbon\Carbon;

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
				$dd = Carbon::createFromFormat('Y-m-d H:i:s', $match->date);
				$mm->match_date = $dd;
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
	
	function saveToDb(string $table, array $values)
	{
		$matchRequestToInsert = 'INSERT INTO matches(`date`, `slug`) VALUES (:date, :slug)';
		$pdoSt = $this->connection->prepare($matchRequestToInsert);
		$pdoSt->execute([':date' => $values['date'], ':slug' => '']);
		
		// for some reason, I get an Integrity constraint violation if the number of goals is more than 1 digit long
		$id = $this->connection->lastInsertId();
		$eventRequestToInsert = 'INSERT INTO events(`match_id`, `team_id`, `goals`, `is_home_team`) VALUES (:match_id, :team_id, :goals, :is_home_team)';
		$pdoSt = $this->connection->prepare($eventRequestToInsert);
		$pdoSt->execute([
			':match_id' => $id,
			':team_id' => $values['home-team'],
			':goals' => $values['home-team-goals'],
			':is_home_team' => 1
		]);
		$pdoSt = $this->connection->prepare($eventRequestToInsert);
		$pdoSt->execute([
			':match_id' => $id,
			':team_id' => $values['away-team'],
			':goals' => $values['away-team-goals'],
			':is_home_team' => 0
		]);
	}
}
