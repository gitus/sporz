<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Sporz</title>
		<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
<nav class="navbar navbar-inverse navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">Sporz</a>
			<?php
			if ($this->get('username') != null) {
				?>
				<p class="navbar-text">Hello, <?= $this->get('username'); ?>!</p>
				<?php
				}
			?>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="/">Home</a></li>
				<li><a href="/login">Sign in</a></li>
				<li><a href="/game/add">Create Game</a></li>
			</ul>
		</div>
	</div>
</nav>
<div class="container-fluid">
	<?php
	$flashMessages = $this->flushFlash();
	if (!empty($flashMessages)) {
		?>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<?php
				foreach ($flashMessages as $flash) {
					?>
					<div class="alert alert-<?= $flash['class']; ?>">
						<?= $flash['message']; ?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	}
	?>
	<div class="row">
		<div class="col-sm-12 col-md-12 main">
			<?php $this->yields(); ?>
		</div>
	</div>
</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
	<script src="/javascripts/bootstrap.min.js"></script>
	</body>
</html>
