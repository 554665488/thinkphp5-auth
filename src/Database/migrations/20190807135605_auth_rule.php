<?php

use Phinx\Migration\AbstractMigration;

class AuthRule extends AbstractMigration
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
        //https://www.jianshu.com/p/894662846d8c
        // create the table
        $table = $this->table('auth_rule', array('engine' => 'InnoDB', 'CHARSET' => 'utf8', 'comment' => '规则表'));
        if ($table->exists()) $table->drop();
        $table->addColumn('name', 'string', array('limit' => 120, 'null' => false, 'default' => '', 'comment' => '规则唯一标识'))
            ->addColumn('title', 'string', array('limit' => 32, 'null' => false, 'default' => '', 'comment' => '权限中文名称'))
            ->addColumn('method', 'string', array('limit' => 32, 'null' => false, 'default' => 'get', 'comment' => '请求方式'))
            ->addColumn('parent_id', 'integer', array('limit' => 11, 'null' => false, 'default' => 0, 'comment' => '父级规则ID'))
            ->addColumn('status', 'boolean', array('limit' => 1, 'null' => false, 'default' => 0, 'comment' => '状态：为1正常，为0禁用'))
            ->addColumn('condition', 'string', array('limit' => 255, 'null' => false, 'default' => '', 'comment' => '规则表达式，为空表示存在就验证，不为空表示按照条件验证'))
            ->addTimestamps()
            ->addIndex(array('name'), array('unique' => true))
//            ->setForeignKeys()
            ->create();
    }
}
