<h2><?= $this->get('game')->name; ?>
<a href="<?= $this->get('edit-link'); ?>">Edit</a></h2>
<div>
    Created at: <?= $this->get('game')->created; ?><br>
    Last modified: <?= $this->get('game')->updated; ?>
</div>
