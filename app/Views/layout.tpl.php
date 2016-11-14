<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Sporz</title>
        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
    <h1>Sporz</h1>
	<?php
	foreach ($this->flushFlash() as $flash) {
		?>
		<div class="alert alert-<?= $flash['class']; ?>">
			<?= $flash['message']; ?>
		</div>
		<?php
	}
	?>
    <ul class="nav nav-tabs">
        <li role="presentation">
            <a href="/">Home</a>
        </li>
        <li role="presentation">
            <a href="/game/add">Create Game</a>
        </li>
    </ul>
    <?php $this->yields(); ?>
	</body>
</html>
