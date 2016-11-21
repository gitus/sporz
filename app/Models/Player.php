<?php

namespace App\Models;

class Player extends \Pragma\ORM\Model
{
    const GENOME_HOST       = 0;
    const GENOME_NORMAL     = 1;
    const GENOME_RESISTANT  = 2;

    const ROLE_ASTRONAUT  = 0;
    const ROLE_MEDIC  = 1;
    const ROLE_PSYCHO  = 2;
    const ROLE_GENETIC  = 3;
    const ROLE_HACKER  = 4;
    const ROLE_IT  = 5;
    const ROLE_SPY  = 6;

    public function __construct()
    {
        return parent::__construct('player');
    }

    public function setGenome($genome)
    {
        if (!in_array($genome, [self::GENOME_HOST, self::GENOME_RESISTANT, self::GENOME_NORMAL])) {
            $genome = self::GENOME_NORMAL;
        }

        $this->genome = $genome;
    }

    public function setRole($role)
    {
        if (!in_array($role, [self::ROLE_ASTRONAUT, self::ROLE_MEDIC, self::ROLE_PSYCHO,self::ROLE_GENETIC, self::ROLE_HACKER, self::ROLE_IT,self::ROLE_SPY])) {
            $role = self::ROLE_ASTRONAUT;
        }

        $this->role = $role;
    }

    public function mutate()
    {
        if ($this->genome != self::GENOME_RESISTANT) {
            $this->mutated = 1;
        }

        return $this->mutated;
    }

    public function cure()
    {
        if ($this->genome != self::GENOME_HOST) {
            $this->mutated = 0;
        }

        return !$this->mutated;
    }
}
