<h2><?= $this->get('game')->name; ?></h2>
<div>
	Turn: <?= $this->get('game')->turn; ?><br>
	Your role: <?= $this->get('player')->role; ?><br>
	Your condition: <?= $this->get('player')->mutated?"Mutant":"Human"; ?><br>
</div>
