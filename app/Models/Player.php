<?php

namespace App\Models;

class Player extends \Pragma\ORM\Model
{
	private $name;
	private $keyId;
	private $genome;
	private $role;
	private $paralysed;
	private $mutated;

	public function __construct()
	{
		return parent::__construct();
	}

}
