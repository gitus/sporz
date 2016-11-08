<?php
class Player{
	private $name;
	private $keyId;
	private $genome;
	private $role;
	private $paralysed;
	private $mutated;

	public function __construct($name){
		$this->name=$name;
		$this->keyId=Game->genKeyId();
		$this->genome=0;
		$this->role="astronaute";
		$this->paralysed=0;
		$this->mutated=0;
	}
	
	public function getName(){
		return $this->name;
	}

	public function getKeyId(){
		return $this->keyId;
	}

	public function getGenome(){
		return $this->genome;
	}

	public function setGenome($genome){
		if($genome>0){
			$genome=1;
		}elseif($genome<0){
			$genome=-1;
		}else{
			$genome=0;
		}
		$this->genome=$genome;
	}

	public function getRole(){
		return $this->role;
	}

	public function isParalysed(){
		return $this->paralysed;
	}

	public function isMutated(){
		return $this->mutated;
	}

	public function mutate(){
		$this->mutated=1;
	}
}
?>
