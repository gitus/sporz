<?php
$username   = $this->get('username');
$token      = $this->get('token');
?>
<form method="post" action="/login">
	<h2>Sign in</h2>
	<div class="form-group">
		<label for="name">Name:</label>
        <input type="name" name="name" id="name" placeholder="john" value="<?= $username; ?>">
	</div>
	<div class="form-group">
		<label for="token">Password:</label>
        <input type="text" name="token" id="token" value="<?= $token; ?>">
	</div>
	<button type="submit" class="btn btn-default">Login</button>
</form>
