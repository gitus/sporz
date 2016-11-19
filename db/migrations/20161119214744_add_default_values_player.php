<?php

use Phinx\Migration\AbstractMigration;

class AddDefaultValuesPlayer extends AbstractMigration
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
    public function up()
    {
        $player = $this->table('player');

        $player->addForeignKey('game_id', 'game', 'id', array('delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'));
	$player->changeColumn('name', 'string', array('null'=>false, 'limit'=>50));
	$player->changeColumn('genome', 'integer', array('null'=>false, 'signed'=>false, 'default'=>1));
	$player->renameColumn('camp', 'mutated');
	$player->changeColumn('mutated', 'integer', array('null'=>false, 'signed'=>false, 'default'=>0));
	$player->renameColumn('state', 'paralysed');
	$player->changeColumn('paralysed', 'integer', array('null'=>false, 'signed'=>false, 'default'=>0));
        $player->addColumn('role',     'string',  array('null' => false, 'limit'=>15, 'default'=>'astronaut'));
	

        $player->save();
    }

    public function down()
    {
	    $player = $this->table('player');

	    $player->dropForeignKey('game_id');

	    $player->changeColumn('name',      'string',   array('limit' => 20));
	    $player->renameColumn('mutated','camp');
	    $player->changeColumn('camp',      'integer',  array('signed' => false, 'null'=>true));
	    $player->changeColumn('genome',    'integer',  array('signed' => false, 'null'=>true));
	    $player->renameColumn('paralysed','state');
	    $player->changeColumn('state',     'integer',  array('signed' => false, 'null'=>true));
	    $player->removeColumn('role');

	    $player->save();
    }
}
