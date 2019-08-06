<?php

use think\migration\Migrator;
use think\migration\db\Column;

class User extends Migrator
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
        //更多用户属性自己定义
        $table = $this->table('y_user');
        if ($table->exists()) $table->drop();
        $table->setId('id')->setPrimaryKey('id')->setEngine('MyISAM')->setComment('用户表')
            ->addTimestamps()
            ->addColumn('user_name', 'string', array('limit' => 32, 'null'=> false, 'default' => '', 'comment' => '用户帐号'))
            ->addColumn('password', 'string', array('limit' => 64, 'null'=> false, 'default' => '', 'comment' => '用户密码'))
            ->addColumn('status', 'boolean', array('limit' => 1, 'null'=> false, 'default' => 0, 'comment' => '状态：为1正常，为0禁用'))
            ->addIndex(array('user_name'))
            ->create();
    }
}
