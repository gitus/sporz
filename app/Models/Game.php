<?php

namespace App\Models;

class Game extends \Pragma\ORM\Model
{
    const PHASE_DAY     = 0;
    const PHASE_NIGHT   = 1;

    public $players;

    public function __construct()
    {
        return parent::__construct('game');
    }

    public function open($gameId)
    {
        $ret = parent::open($gameId);

        $this->players = Player::forge()->where('game_id', '=', $this->id)->get_objects();

        return $ret;
    }

    //the KeyId is the string used by a player in order to authenticate in-game (security is not a concern here)
    public static function genKeyId()
    {
        //TODO
    }

    public function addPlayer(Player $player)
    {
	    if ($player == null) {
		    return false;
		}

		if ($this->started) {
			return false;
		}

		if ($this->getPlayerByName($player->name)) {
			return false;
		}

		$player->game_id = $this->id;
		$player->save();

        $this->players[] = $player;

        return true;
    }

    public function getPlayerByRole($role)
    {
        $tmp = array();
        foreach ($this->players as $player) {
            if ($role == $player->role) {
                array_push($tmp, $player);
            }
        }
        if (count($tmp) > 1) {
            return $tmp;
        }
        if (count($tmp) == 1) {
            return $tmp[0];
        }

        return null;
    }

    public function getPlayerByName($name)
    {
        foreach ($this->players as $player) {
            if ($name == $player->name) {
                return $player;
            }
        }

        return null;
    }

    public function isAttached(Player $player)
    {
        foreach ($this->players as $attachedPlayer) {
            if ($player->id == $attachedPlayer->id) {
                return true;
            }
        }

        return false;
    }

    public function startGame()
    {
        if (count($this->players) >= 7) {
            $this->started = 1;
            $this->turn = 1;
            $this->initGame();
            $this->save();
            return true;
        }
    return false;
    }

    public function initGame()
    {
        if (count($this->players) < 7) {
            return false;
        }

        shuffle($this->players);

        $bad_guy = array_shift($this->players);
        $bad_guy->setGenome(Player::GENOME_HOST);
        $bad_guy->mutate();

        $first_doc = array_shift($this->players);
        $first_doc->role = 'medic';

        $second_doc = array_shift($this->players);
        $second_doc->role = 'medic';

        $index_of_modified_genomes = array_rand($this->players, 2);
        $this->players[$index_of_modified_genomes[0]]->setGenome(Player::GENOME_HOST);
        $this->players[$index_of_modified_genomes[1]]->setGenome(Player::GENOME_RESISTANT);

        $this->players[] = $bad_guy;
        $this->players[] = $first_doc;
        $this->players[] = $second_doc;

        $some_guy = array_shift($this->players);
        $some_guy->role = 'psy';
        $this->players[] = $some_guy;

        $some_guy = array_shift($this->players);
        $some_guy->role = 'geneticist';
        $this->players[] = $some_guy;

        $some_guy = array_shift($this->players);
        $some_guy->role = 'it';
        $this->players[] = $some_guy;

        $some_guy = array_shift($this->players);
        $some_guy->role = 'hacker';
        $this->players[] = $some_guy;

        foreach ($this->players as $player) {
		$player->save();
	}

        return true;
    }

    public function electLeader($name)
    {
        $wanabe = getPlayerByName($name);
        if ($wanabe && $wanabe->alive) {
            $this->leader = $name;

            return true;
        }

        return false;
    }

    public static function getNonStartedGame()
    {
        return self::forge()->where('started', '=', 0)->get_objects();
    }
}
