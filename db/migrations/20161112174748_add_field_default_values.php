<?php

use Phinx\Migration\AbstractMigration;

class AddFieldDefaultValues extends AbstractMigration
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
        $game = $this->table('game');

        $game->changeColumn('phase',        'integer', array('default' => 0, 'null' => false));
        $game->changeColumn('turn_number',  'integer', array('default' => 0, 'null' => false));
        $game->changeColumn('started',      'integer', array('default' => 0, 'null' => false));

        $game->save();

        $player = $this->table('player');

        $player->changeColumn('alive', 'integer', array('default' => 1, 'null' => false));

        $player->save();
    }

    public function down()
    {
        $game = $this->table('game');

        $game->changeColumn('phase',        'integer', array('null' => true, 'default' => null));
        $game->changeColumn('turn_number',  'integer', array('null' => true, 'default' => null));
        $game->changeColumn('started',      'integer', array('null' => true, 'default' => null));

        $game->save();

        $player = $this->table('player');

        $player->changeColumn('alive', 'integer', array('null' => true, 'default' => null));

        $player->save();
    }
}
