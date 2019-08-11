<?php

namespace thinkAuth\Model;

use think\facade\Config;
use think\facade\Request;
use think\Model;
use thinkAuth\Lib\ArrayHelp;

/**
 * Class AuthModel
 * @package thinkAuth\Model
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date:二〇一九年八月十日 22:46:00
 * @Description:权限管理模型
 */
class AuthModel extends Model
{
    public function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '开启', 2 => '待审核'];
        return $status[$value];
    }

    public function setStatusAttr($value)
    {
        if ($value == 'on') return 1;
        return 0;
    }

    public function setTitleAttr($value)
    {
        return str_replace('➥', '', $value);
    }

    public function __construct($data = [])
    {
        parent::__construct($data);
        //设置表名
        $this->table = !empty(Config::get('auth.table.auth_rule')) ? Config::get('auth.table.auth_rule') : 'y_auth_rule';
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 20:22:53
     * @Description:获得权限列表
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthsByPage()
    {
        $page = Request::get('page', 1, 'intval');
        $limit = Request::get('limit', 30, 'intval');
        //搜索条件
        $map = [];
        if (Request::has('search')) {
            $map[] = ['title', 'like', Request::get('search') . '%'];
            $map[] = ['name', 'like', Request::get('search') . '%'];
        }
        $auths = $this->field('*')->page($page, $limit)->whereOr($map)->order(['id' => 'desc'])->select();
        $arrayHelp = new ArrayHelp();
        $auths = $arrayHelp->getList($auths->toArray());
        foreach ($auths as $index => $auth) {
            $auths[$index]['title'] = str_repeat('➥', $auth['level']) . $auth['title'];
        }
        return $auths;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获取权限列表的数量
     * @return float|string
     */
    public function getAuthsCount()
    {
        $map = [];
        if (Request::has('search')) {
            $map[] = ['title', 'like', Request::get('search') . '%'];
            $map[] = ['name', 'like', Request::get('search') . '%'];
        }
        return $this->field('*')->whereOr($map)->count();
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:42:45
     * @Description:创建权限
     * @return bool
     */
    public function createAuth()
    {
        $user = self::create(Request::post());
        return $user['id'] ?? false;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:更新权限信息
     * @Description:
     * @return AuthModel
     */
    public function updateAuth()
    {
        $user = self::update(Request::post());
        return $user;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 23:18:56
     * @Description:删除权限规则 一个或者多个
     * @return bool
     */
    public function destroyAuth()
    {
        return self::destroy(Request::post('id'));
    }

    /**
     * @param string $type
     * @param string $cacheKey 缓存key
     * @param int $expire 大于零缓存
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获取所有权限树状结构或者顺序结构
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllAuths($type = '', $cacheKey = 'auths', $expire = 0)
    {
        $arrayHelp = new ArrayHelp();
        //where 条件
        $map = [];
        if (Request::has('edit_id')) {
            //用排除自己
            $map[] = ['id', 'neq', Request::param('edit_id')];
        }
        if ($expire) {
            $authList = $this->field('*')->where($map)->order('id', 'desc')->cache($cacheKey, $expire)->select();
        } else {
            $authList = $this->field('*')->where($map)->order('id', 'desc')->select();
        }
        //直接返回
        if (empty($type)) return $authList->toArray();
        //处理后返回结果
        return $arrayHelp->$type($authList->toArray());
    }
}