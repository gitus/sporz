<h2><?= $this->get('game')->name; ?></h2>
<a href="<?= $this->get('edit-link'); ?>">Edit</a>
<div>
    Created at: <?= $this->get('game')->created; ?><br>
    Last modified: <?= $this->get('game')->updated; ?>
</div>
