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
            <a href="<?= $this->get('router')->url_for('game-detail', ['gameid' => $game->id]); ?>">
                <td><?= $game->id; ?></td>
                <td><?= $game->name; ?></td>
                <td><?= $game->name; ?></td>
                <td><?= $game->name; ?></td>
            </a>
        </tr>
        <?php
    }
    ?>
</ul>
