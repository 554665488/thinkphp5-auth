<?php

use think\migration\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data  =
            [
                'user_name'        =>  'admin' ,
                'email'        =>  getRandStrByLength(). '@qq.com' ,
                'password'        =>  '9OHkSqf4SZkZNkMuCzTwU58KSKF7qblCLgJKq6GuWjc',
                'experience'    =>  mt_rand(1,2)
            ];
        $this->table('y_user')->insert($data)->save();
    }
}