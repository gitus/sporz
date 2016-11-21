<?php

use Phinx\Migration\AbstractMigration;

class ChangeRoleIntoInteger extends AbstractMigration
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
        $player->changeColumn('role',        'integer', array('signed'=>false, 'default' => 0, 'null' => false));
        $player->save();
    }
    public function down()
    {
        $player = $this->table('player');
        $player->changeColumn('role',     'string',  array('null' => false, 'limit'=>15, 'default'=>'astronaut'));
        $player->save();
    }
}
