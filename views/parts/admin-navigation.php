<div role="navigation">
	<a href="/?action=create&resource=team">Add a team</a> - 
	<a href="/?action=create&resource=match">Add a match</a>
</div>
<div role="logout">
	<form action="index.php" method="POST">
		<input type="hidden" name="action" value="destroy">
		<input type="hidden" name="resource" value="login">
		<input type="submit" value="logout">
	</form>
</div>