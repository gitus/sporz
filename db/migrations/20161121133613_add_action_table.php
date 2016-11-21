<?php

use Phinx\Migration\AbstractMigration;

class AddActionTable extends AbstractMigration
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
        $actions = $this->table('action');
	$actions->addColumn('player_id', 'integer', array('signed'=>false, 'null'=>false));
        $actions->addForeignKey('player_id', 'player', 'id', array('delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'));
	$actions->addColumn('turn', 'integer', array('signed'=>false, 'null'=>false));
	$actions->addColumn('type_action', 'string', array('limit'=>20));
	$actions->addColumn('target_id', 'integer', array('signed'=>false));
        $actions->addForeignKey('target_id', 'player', 'id', array('delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'));
	$actions->addColumn('confirmed', 'integer', array('signed'=>false,'null'=>false,'default'=>0));
        $actions->create();
    }
}
