<form method="post" action="<?= $this->get('form-action'); ?>">
	<h2><?= $this->get('game')->is_new() ? 'Create' : 'Edit'; ?></h2>
	<div class="form-group">
		<label for="name">Name:</label>
		<input type="text" name="name" id="name" value="<?= $this->get('game')->name; ?>">
	</div>
	<button type="submit" class="btn btn-default">Submit</button>
</form>
