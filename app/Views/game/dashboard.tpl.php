<h2><?= $this->get('game')->name; ?></h2>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li>Turn: <?= $this->get('game')->turn; ?></li>
				<li>Your role: <?= $this->get('player')->role; ?></li>
				<li>Your condition: <?= $this->get('player')->mutated?"Mutant":"Human"; ?></li>
			</ul>
		</div>
		<h2 class="sub-header">Joueurs décédés</h2>
		<div class="table-responsive">
			<table class="table table-striped">
			<thead>
			<tr>
			<th>Name</th>
			<th>Role</th>
			<th>State</th>
			</tr>
			</thead>
		</div>
	</div>
</div>

<!-- behold mortal -->

<script>
</script>
