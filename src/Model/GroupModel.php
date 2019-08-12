<?php

namespace thinkAuth\Model;

use think\facade\Config;
use think\facade\Request;
use think\Model;

/**
 * Class UserModel
 * @package thinkAuth\Model
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date:二〇一九年八月十日 22:45:32
 * @Description:用户组信息模型
 */
class GroupModel extends Model
{
    public function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$value];
    }

    public function setStatusAttr($value)
    {
        if ($value == 'on') return 1;
        return 0;
    }


    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->table = !empty(Config::get('auth.table.auth_group')) ? Config::get('auth.table.auth_group') : 'y_auth_group';
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获取权限组列表
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGroupsByPage()
    {
        $page = Request::get('page', 1, 'intval');
        $limit = Request::get('limit', 30, 'intval');
        $map = [];
        if (Request::has('search')) {
            $map[] = ['title', 'like', Request::get('search') . '%'];
        }
        return $this->field('*')->page($page, $limit)->whereOr($map)->order('id', 'desc')->select();
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:44:04
     * @Description:获取权限组数量 用于layui分页
     * @return float|string
     */
    public function getGroupCount()
    {
        $map = [];
        if (Request::has('search')) {
            $map[] = ['title', 'like', Request::get('search') . '%'];
        }
        return $this->field('*')->whereOr($map)->count();
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:创建用户
     * @return bool
     */
    public function createUser()
    {
        $user = self::create(Request::post());
        return $user['id'] ?? false;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:44:38
     * @Description:更新用户信息
     * @return UserModel
     */
    public function updateUser()
    {
        $user = self::update(Request::post());
        return $user;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:45:08
     * @Description:单个或则批量删除用户信息
     * @return bool
     */
    public function destroyUser()
    {
        return self::destroy(Request::post('id'));
    }
}