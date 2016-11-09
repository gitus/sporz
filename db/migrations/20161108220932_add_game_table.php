<?php

use Phinx\Migration\AbstractMigration;

class AddGameTable extends AbstractMigration
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
        $game = $this->table('game');

        $game->addColumn('name',    'string',   array('limit' => 20));
        $game->addColumn('phase',   'integer',  array('signed' => false));

        $game->addColumn('created', 'datetime');
        $game->addColumn('updated', 'datetime');

        $game->addIndex(array('name'), array('unique' => true));

        $game->create();
    }
}
