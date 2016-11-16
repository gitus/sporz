<?php

use Phinx\Migration\AbstractMigration;

class RemoveUniquenessFromPlayerToken extends AbstractMigration
{
    public function up()
    {
        $player = $this->table('player');

        $player->removeIndex(array('token'));
        $player->addIndex(array('token'));

        $player->save();
    }

    public function down()
    {
        $player = $this->table('player');

        $player->removeIndex(array('token'));
        $player->addIndex(array('token'), array('unique' => true));

        $player->save();
    }
}
