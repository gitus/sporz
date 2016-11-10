<?php

namespace App\Models;

define("DAY",0);
define("NIGHT",1);

class Game extends \Pragma\ORM\Model
{
	private $players;
	private $id;
	private $started;
	private $phase;
	private $leader;

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

	public function getPlayerByRole($role){
		$tmp=array();
		foreach($this->players as $player){
			if($role == $player->role){
				array_push($tmp,$player);
			}
		}
		if(count($tmp)>1){
			return $tmp;
		}
		if(count($tmp)==1){
			return $tmp[0];
		}
		return null;
	}
	public function getPlayerByName($name){
		foreach($this->players as $player){
			if($name == $player->name){
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
		if(count($this->players)<7){
			return false;
		}
		shuffle($this->players);

		$bad_guy=array_shift($this->players);
		$bad_guy->mutate();
		$bad_guy->setGenome(-1);

		$first_doc=array_shift($this->players);
		$fist_doc->role="medic";

		$second_doc=array_shift($this->players);
		$second_doc->role="medic";

		$index_of_modified_genomes=array_rand($this->players, 2);
		$this->players[$index_of_modified_genomes[0]]->setGenome(-1);
		$this->players[$index_of_modified_genomes[1]]->setGenome(1);

		array_push($this->players, $bad_guy, $first_doc, $second_doc);
		
		$some_guy=array_shift($this->players);
		$some_guy->role="psy";
		array_push($this->players,$some_guy);
		$some_guy=array_shift($this->players);
		$some_guy->role="geneticist";
		array_push($this->players,$some_guy);
		$some_guy=array_shift($this->players);
		$some_guy->role="it";
		array_push($this->players,$some_guy);
		$some_guy=array_shift($this->players);
		$some_guy->role="hacker";
		array_push($this->players,$some_guy);
		return true;
	}

	public function electLeader($name){
		$wanabe=getPlayerByName($name);
		if($wanabe && $wanabe->alive){
			$this->leader=$name;
			return true;
		}
		return false;
	}

	public static function getNonStartedGame(){
		$joinable=Game::all();
		foreach($joinable as $k=>$val){
			if($val->started){
				unset($joinable[$k]);
			}
		}
		return $joinable;
	}
}
