<form method="post" action="/login">
	<h2>Sign in</h2>
	<div class="form-group">
		<label for="name">Name:</label>
		<input type="name" name="name" id="name" placeholder="john" value="<?= $this->get('username'); ?>">
	</div>
	<div class="form-group">
		<label for="token">Password:</label>
		<input type="text" name="token" id="token" value="<?= $this->get('usertoken'); ?>">
	</div>
	<button type="submit" class="btn btn-default">Login</button>
</form>
