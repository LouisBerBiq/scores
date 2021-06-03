<?php if($_SESSION['errors']): ?>
	<?php foreach($_SESSION['errors'] as $error): ?>
		<div>
			<p><?= $error ?></p>
		</div>
	<?php endforeach; ?>
<?php endif; ?>