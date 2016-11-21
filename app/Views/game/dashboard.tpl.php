<h2>Game: <strong><?= $this->get('game')->name; ?></strong></h2>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<h3 class="sub-header">Summary</h3>
			<ul class="nav nav-sidebar">
				<li>Turn: <?= $this->get('game')->turn; ?></li>
				<li>Your role: <?= $this->get('player')->role; ?></li>
				<li>Your condition: <?= $this->get('player')->mutated?"Mutant":"Human"; ?></li>
			</ul>
		</div>
		<div class="col-sm-12 col-md-10">
			<h3 class="sub-header">Joueurs décédés</h3>
			<div class="table-responsive">
				<table class="table table-striped">
				<thead>
				<tr>
				<th>Name</th>
				<th>Role</th>
				<th>State</th>
				</tr>
				</thead>
				</table>
			</div>
		<div>
	</div>
</div>

<!-- behold mortal -->

<script>
</script>
