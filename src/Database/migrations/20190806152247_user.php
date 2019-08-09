<?php

use Phinx\Migration\AbstractMigration;

class User extends AbstractMigration
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
        $table = $this->table('y_user', array('engine'=>'InnoDB','CHARSET'=>'utf8'));
        if ($table->exists()) $table->drop();
        $table->addTimestamps()
            ->addColumn('user_name', 'string', array('limit' => 32, 'null'=> false, 'default' => '', 'comment' => '用户帐号'))
            ->addColumn('password', 'string', array('limit' => 64, 'null'=> false, 'default' => '', 'comment' => '用户密码'))
            ->addColumn('status', 'boolean', array('limit' => 1, 'null'=> false, 'default' => 0, 'comment' => '状态：为1正常，为0禁用'))
            ->addColumn('email', 'string', array('limit' => 32, 'null' => false, 'default' => '', 'comment' => '邮箱'))
            ->addColumn('sex', 'enum', array('limit' => 32, 'null' => false, 'default' => 1, 'values' =>'1,2', 'comment' => '性别 1男 2女'))
            ->addColumn('experience', 'integer', array('limit' => 11, 'null' => false, 'default' => 1, 'comment' => '积分'))
            ->addColumn('ip', 'string', array('limit' => 20, 'null' => false, 'default' => '', 'comment' => 'IP'))
            ->addColumn('login_count', 'integer', array('limit' => 11, 'null' => false, 'default' => 1, 'comment' => '登录次数'))
            ->addIndex(array('user_name'))
            ->create();

    }

    /**
     * Migrate Up.
     */
    public function up()
    {

    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
