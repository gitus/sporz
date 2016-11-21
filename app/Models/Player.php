<?php

namespace App\Models;

class Player extends \Pragma\ORM\Model
{
    const GENOME_HOST       = 0;
    const GENOME_NORMAL     = 1;
    const GENOME_RESISTANT  = 2;

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
