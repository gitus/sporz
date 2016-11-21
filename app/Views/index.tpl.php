<h2>Lobby</h2>
<ul>
	<?php
	foreach ($this->get('joinableGames') as $game) {
		?>
		<li>
			<a href="<?= $this->get('router')->url_for('game-detail', ['gameid' => $game->id]); ?>">
				<?= $game->name; ?>
			</a>
		</li>
		<?php
	}
	?>
</ul>
