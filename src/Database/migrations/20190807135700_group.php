<?php

use Phinx\Migration\AbstractMigration;

class AuthGroup extends AbstractMigration
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
        $table = $this->table('group',array('engine' => 'InnoDB', 'CHARSET' => 'utf8', 'comment' => '用户组表'));
        if ($table->exists()) $table->drop();
        $table->addTimestamps()
            ->addColumn('title', 'string', array('limit' => 32, 'null'=> false, 'default' => '', 'comment' => '用户组中文名称'))
            ->addColumn('status', 'boolean', array('limit' => 1, 'null'=> false, 'default' => 0, 'comment' => '状态：为1正常，为0禁用'))
            //->addColumn('rules', 'string', array('limit' => 100, 'null'=> false, 'default' => '', 'comment' => '用户组拥有的规则id'))
//            ->addIndex(array('rules'))
            ->create();
    }
}
