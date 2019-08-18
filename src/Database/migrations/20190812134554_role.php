<?php

use think\migration\Migrator;
use think\migration\db\Column;

class UserRole extends Migrator
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
        $table = $this->table('role', array('engine'=>'InnoDB','CHARSET'=>'utf8', 'comment' => '系统用户角色表'));
        if ($table->exists()) $table->drop();
        $table->addTimestamps()
            ->addColumn('name', 'string', array('limit' => 32, 'null' => false, 'default' => '', 'comment' => '角色名字'))
            ->addColumn('status', 'boolean', array('limit' => 1, 'null'=> false, 'default' => 0, 'comment' => '状态：为1正常，为0禁用'))
            ->addColumn('level', 'integer', array('limit' => 5, 'null' => false, 'default' => 1, 'comment' => '角色级别'))
            ->addColumn('parent_id', 'integer', array('limit' => 5, 'null' => false, 'default' => 1, 'comment' => '当前角色的上一级角色ID'))
            ->addIndex(array('level'))
            ->create();
    }
}
