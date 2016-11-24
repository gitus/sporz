<?php

require_once __DIR__.'/config.php';

use App\Models\Player;

class Playertest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider setGenomeProvider
	 */
	public function testSetGenome($assignedGenome, $expectedGenome)
	{
		$player = new Player();

		$player->setGenome($assignedGenome);

		$this->assertEquals($expectedGenome, $player->genome);
	}

	public function setGenomeProvider()
	{
		return array(
			// Valid genomes
			array(Player::GENOME_HOST,          Player::GENOME_HOST),
			array(Player::GENOME_NORMAL,        Player::GENOME_NORMAL),
			array(Player::GENOME_RESISTANT,     Player::GENOME_RESISTANT),
			// Invalid genomes
			array(~Player::GENOME_HOST,         Player::GENOME_NORMAL),
			array(~Player::GENOME_NORMAL,       Player::GENOME_NORMAL),
			array(~Player::GENOME_RESISTANT,    Player::GENOME_NORMAL),
		);
	}

	/**
	 * @dataProvider setRoleProvider
	 */
	public function testSetRole($assignedRole, $expectedRole)
	{
		$player = new Player();

		$player->setRole($assignedRole);

		$this->assertEquals($expectedRole, $player->role);
	}

	public function setRoleProvider()
	{
		return array(
			// Valid roles
			array(Player::ROLE_ASTRONAUT,   Player::ROLE_ASTRONAUT),
			array(Player::ROLE_MEDIC,       Player::ROLE_MEDIC),
			array(Player::ROLE_PSYCHO,      Player::ROLE_PSYCHO),
			array(Player::ROLE_GENETIC,     Player::ROLE_GENETIC),
			array(Player::ROLE_HACKER,      Player::ROLE_HACKER),
			array(Player::ROLE_IT,          Player::ROLE_IT),
			array(Player::ROLE_SPY,         Player::ROLE_SPY),
			// Invalid role
			array(~Player::ROLE_ASTRONAUT,  Player::ROLE_ASTRONAUT),
			array(~Player::ROLE_MEDIC,      Player::ROLE_ASTRONAUT),
			array(~Player::ROLE_PSYCHO,     Player::ROLE_ASTRONAUT),
			array(~Player::ROLE_GENETIC,    Player::ROLE_ASTRONAUT),
			array(~Player::ROLE_HACKER,     Player::ROLE_ASTRONAUT),
			array(~Player::ROLE_IT,         Player::ROLE_ASTRONAUT),
			array(~Player::ROLE_SPY,        Player::ROLE_ASTRONAUT),
		);
	}

	/**
	 * @dataProvider mutateProvider
	 */
	public function testMutate($assignedGenome, $expectedMutation)
	{
		$player = new Player();
		$player->mutated = 0;
		$player->setGenome($assignedGenome);

		$player->mutate();

		$this->assertEquals($expectedMutation, $player->mutated);
	}

	public function mutateProvider()
	{
		return array(
			array(Player::GENOME_HOST,          1),
			array(Player::GENOME_NORMAL,        1),
			array(Player::GENOME_RESISTANT,     0),
		);
	}

	/**
	 * @dataProvider cureProvider
	 */
	public function testCure($assignedGenome, $expectedMutation)
	{
		$player = new Player();
		$player->mutated = 1;
		$player->setGenome($assignedGenome);

		$player->cure();

		$this->assertEquals($expectedMutation, !$player->mutated);
	}

	public function cureProvider()
	{
		return array(
			array(Player::GENOME_HOST,          0),
			array(Player::GENOME_NORMAL,        1),
			array(Player::GENOME_RESISTANT,     1),
		);
	}
}

