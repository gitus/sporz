<?php

class Game extends Pragma\ORM\Model
{
	private $players;
	private $id;
	private $started;
	private $phase;

	public function __construct()
	{
		return parent::__construct('game');
	}

	//the KeyId is the string used by a player in order to authenticate in-game (security is not a concern here)
	public static function genKeyId(){
		//TODO
	}

	public function addPlayer($name)
	{
		$keyId=null;
		if(!($this->started) && getPlayerByName($name)==null){
			$new_player=new Player($name);
			$keyId=$new_player->getKeyId();
			array_push($this->players,$new_player);
		}
		return $keyId;
	}

	public function getPlayerByName($name){
		foreach($this->players as $player){
			if($name == $player->getName()){
				return $player;
			}
		}
		return null;
	}

	public function startGame(){
		if(count($this->players)>=7){
			$this->started=1;
			$this->initGame();
		}
	}

	public function initGame(){
		shuffle($this->players);

		$bad_guy=array_shift($this->players);
		$bad_guy->mutate();
		$bad_guy->setGenome(-1);

		$first_doc=array_shift($this->players);
		$fist_doc->setRole("medecin");

		$second_doc=array_shift($this->players);
		$second_doc->setRole("medecin");

		$index_of_modified_genomes=array_rand($this->players, 2);
		$this->players[$index_of_modified_genomes[0]]->setGenome(-1);
		$this->players[$index_of_modified_genomes[1]]->setGenome(1);

		array_push($this->players, $bad_guy, $first_doc, $second_doc);
	}
}
