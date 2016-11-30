<h2>Game: <strong><?= $this->get('game')->name; ?></strong></h2>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2 sidebar">
			<h3 class="sub-header">Summary</h3>
			<ul class="nav nav-sidebar">
				<li>Turn: <?= $this->get('game')->turn; ?></li>
				<li>Your role: <?= $this->get('player')->role; ?></li>
				<li>Your condition: <?= $this->get('player')->mutated ? "Mutant" : "Human"; ?></li>
			</ul>
		</div>
		<div class="col-sm-12 col-md-10">
			<h3 class="sub-header">Joueurs décédés</h3>
			<div class="table-responsive">
				<table id="dead_players_tab" class="table table-striped">
				<thead>
				<tr>
				<th>Name</th>
				<th>Role</th>
				<th>State</th>
				</tr>
				</thead>
				</table>
			</div>
		</div>
		<div class="col-sm-12 col-md-10">
			<h3 class="sub-header">Joueurs suspects</h3>
			<div class="table-responsive">
				<table id="alive_players_tab" class="table table-striped">
				<thead>
				<tr>
				<th>Name</th>
				<th>Role</th>
				<th>State</th>
				</tr>
				</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- behold mortal -->

<script>
var PHASE_DAY_ELECT_LEADER     = 0;
var PHASE_DAY_VOTE_TO_KILL   = 1;
var PHASE_NIGHT_MUTANT_MUTE_OR_KILL   = 2;
var PHASE_NIGHT_MUTANT_PARALYSE   = 3;
var PHASE_NIGHT_MEDIC   = 4;
var PHASE_NIGHT_PSYCHO   = 5;
var PHASE_NIGHT_GENETIC   = 6;
var PHASE_NIGHT_IT   = 7;
var PHASE_NIGHT_HACKER   = 8;

var current_phase;
var current_turn;
var current_player;
var last_action;

var sound_chicken = new Audio('/sounds/chicken.wav');

setInterval('refreshHUD(<?= $this->get('game')->id; ?>, <?= $this->get('player')->id; ?>)',3000);
function refreshHUD(gameid, playerid){
	sound_chicken.play();
	$.getJSON({
		url: "<?= $this->get('player-link'); ?>",
		context: document.body,
		success: function(player){
			current_player=player;
		}
	});
	//$.getJSON({
	//	url: "<?= $this->get('last-action-link'); ?>",
	//	context: document.body,
	//	success: function(action){
	//		last_action=action;
	//	}
	//});
	$.getJSON({
		url: "<?= $this->get('turn-link'); ?>",
		context: document.body,
		success: function(turn){
			current_turn=turn.result;
		}
	});
	$.getJSON({
		url: "<?= $this->get('phase-link'); ?>",
		context: document.body,
		success: function(phase){
			current_phase=phase.result;
		}
	});
	if(current_phase == PHASE_DAY_ELECT_LEADER || current_phase == PHASE_NIGHT_MUTANT_MUTE_OR_KILL){
		refreshDeadPlayers();
	}
	if(current_phase == PHASE_DAY_ELECT_LEADER || current_phase == PHASE_DAY_VOTE_TO_KILL){
		checkLastAction();
	}
	if((current_phase == PHASE_NIGHT_MUTANT_MUTE_OR_KILL || current_phase == PHASE_NIGHT_MUTANT_MUTE_OR_KILL) && player.mutated){
		checkLastAction();
	}
	if(current_phase == PHASE_NIGHT_MEDIC && player.role == ROLE_MEDIC && !(player.mutated) && !(player.paralysed)){
		checkLastAction();
	}
	if(current_phase == PHASE_NIGHT_PSYCHO && player.role == ROLE_PSYCHO && !(player.paralysed)){
		checkLastAction();
	}
	if(current_phase == PHASE_NIGHT_GENETIC && player.role == ROLE_GENETIC && !(player.paralysed)){
		checkLastAction();
	}
	/*if(current_phase == PHASE_NIGHT_IT && player.role == ROLE_IT && !(player.paralysed)){
		checkLastActionIT();
	}*/
	if(current_phase == PHASE_NIGHT_HACKER && player.role == ROLE_HACKER && !(player.paralysed)){
		checkLastActionHacker();
	}
}
function checkLastAction(){
	if(last_action.turn == current_turn && last_action.phase == current_phase && last_action.confirmed){
		displayWaitMessage();
	}else{
		displayTargetForm();
	}
}
function displayWaitMessage(){
}
function displayTargetForm(){
}
function refreshDeadPlayers(){
	$.getJSON({
		url: "<?= $this->get('dead-players-link'); ?>",
		context: document.body,
		success: function(players){
			if(players.length>$.('#dead_players_tab tr').length){
				$.('#dead_players_tab tr').remove();
				players.forEach(function(p){
					$.('#dead_players_tab thead').append('<tr><td>'+p.name+'</td><td>'+p.role'+</td><td>'+p.mutated'+</td></tr>');
				});
			}
		}
	});
}
</script>
