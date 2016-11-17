<h2><?= $this->get('game')->name; ?></h2>
<a href="<?= $this->get('edit-link'); ?>">Edit</a>
<div>
    Players: <?= count($this->get('game')->players); ?><br>
    Created at: <?= $this->get('game')->created; ?><br>
    Last modified: <?= $this->get('game')->updated; ?>
</div>
