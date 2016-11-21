<h1 class="page-header">Lobby</h1>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Player count</th>
				<th>Joined</th>
			</tr>
		</thead>
		<tbody>
	<?php
	foreach ($this->get('joinableGames') as $game) {
		?>
		<tr>

			<td><a href="<?= $this->get('router')->url_for('game-detail', ['gameid' => $game->id]); ?>"><?= $game->id; ?></a></td>
			<td><a href="<?= $this->get('router')->url_for('game-detail', ['gameid' => $game->id]); ?>"><?= $game->name; ?></a></td>
			<td><a href="<?= $this->get('router')->url_for('game-detail', ['gameid' => $game->id]); ?>"><?= count($game->players); ?></a></td>
			<td><?= $game->name; ?></a></td>
		</tr>
		<?php
	}
	?>
	</table>
</div>
