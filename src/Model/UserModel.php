<?php

namespace thinkAuth\Model;

use think\facade\Config;
use think\facade\Request;
use think\Model;

class UserModel extends Model
{
    public function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$value];
    }
    public function setStatusAttr($value)
    {
        if($value == 'on') return 1;
        return 0;
    }
    public function setPasswordAttr($value)
    {
        return empty($value) ? 0 : password_encrypt($value);
    }
    public function getSexAttr($value)
    {
        $status = [1 => '男', 2 => '女'];
        return $status[$value];
    }

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->table = !empty(Config::get('auth.auth_user')) ? Config::get('auth.auth_user') : 'y_user';
    }

    public function getUsersByPage()
    {
        $page = Request::get('page', 1, 'intval');
        $limit = Request::get('limit', 15, 'intval');

        return $this->field('*')->page($page, $limit)->order('id', 'desc')->select();
    }

    public function getUsersCount()
    {
        return $this->field('*')->count();
    }

    public function createUser()
    {
        $user = self::create(Request::post());
        return $user['id'] ?? false;
    }

    public function updateUser()
    {
        $user = self::update(Request::post());
        return $user;
    }

    public function destroyUser()
    {
        return self::destroy(Request::post('id'));
    }
}