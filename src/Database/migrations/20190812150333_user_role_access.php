<?php

use think\migration\Migrator;
use think\migration\db\Column;

class RoleAccess extends Migrator
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
        $table = $this->table('user_role_access',array('engine' => 'InnoDB', 'CHARSET' => 'utf8', 'comment' => '用户和角色组关联中间表'));
        if ($table->exists()) $table->drop();
        $table->addColumn('uid', 'integer', array('limit' => 11, 'null'=> false, 'default' => 0, 'comment' => '用户ID'))
            ->addColumn('role_id', 'integer', array('limit' => 5, 'null'=> false, 'default' => 0, 'comment' => '用户角色id'))
            ->addIndex(array('uid','role_id'), ['type'=> 'unique'])
            ->create();
    }
}
