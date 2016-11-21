<h2><?= $this->get('game')->name; ?></h2>
<a href="<?= $this->get('edit-link'); ?>">Edit</a>
<?php
if ($this->get('userid') != null) {
	?>
	<a href="<?= $this->get('join-link'); ?>">Join</a>
	<a href="<?= $this->get('startgame-link'); ?>">Start</a>
	<?php
}
?>
<div>
	Players: <?= count($this->get('game')->players); ?><br>
	Created at: <?= $this->get('game')->created; ?><br>
	Last modified: <?= $this->get('game')->updated; ?>
</div>
