<?php

use Phinx\Migration\AbstractMigration;

class AddPlayerTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $player = $this->table('player');

        $player->addColumn('game_id',   'integer',  array('signed' => false));

        $player->addColumn('name',      'string',   array('limit' => 20));
        $player->addColumn('password',  'string',   array('limit' => 20));

        $player->addColumn('alive',     'integer',  array('signed' => false));
        $player->addColumn('camp',      'integer',  array('signed' => false));
        $player->addColumn('genome',    'integer',  array('signed' => false));
        $player->addColumn('state',     'integer',  array('signed' => false));

        $player->addColumn('created', 'datetime');
        $player->addColumn('updated', 'datetime');

        $player->create();
    }
}
