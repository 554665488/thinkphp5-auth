<?php

use Phinx\Migration\AbstractMigration;

class AuthGroupAccess extends AbstractMigration
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
        $table = $this->table('user_group_access',array('engine' => 'InnoDB', 'CHARSET' => 'utf8', 'comment' => '用户和权限组关联中间表'));
        if ($table->exists()) $table->drop();
        $table->addColumn('uid', 'integer', array('limit' => 11, 'null'=> false, 'default' => 0, 'comment' => '用户ID'))
            ->addColumn('auth_group_id', 'integer', array('limit' => 11, 'null'=> false, 'default' => 0, 'comment' => '用户组id'))
            ->addIndex(array('uid','auth_group_id'), ['type'=> 'unique'])
            ->create();
    }
}
