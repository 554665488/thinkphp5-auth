<?php

namespace thinkAuth;

use think\Db;
use think\facade\Cache;
use think\facade\Request;
use think\Session;
use thinkAuth\Model\GroupModel;
use thinkAuth\Model\UserModel;


/**
 * Class AuthService
 * @package thinkAuth\Auth
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date: 2019年8月7日 00:01:02
 * @Description: 基于ThinkPHP5的权限认证
 */
class Auth
{
    private static $instance = null;
    //保存用户的自定义配置参数
    private $setting = [];

    //构造器私有化:禁止从类外部实例化
    private function __construct()
    {
    }

    //克隆方法私有化:禁止从外部克隆对象
    private function __clone()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {

            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $uid
     * @param bool $isCache
     * @param int $expire
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十六日 17:14:56
     * @Description:获取用户属于的组和角色
     * @return array|mixed|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGroupsAndRolesAndAuthsByUid($uid, $isCache = false, $expire = 3600)
    {
        if (!$uid) return [];
        $where [] = ['id', '=', $uid];

        if ($userInfo = Cache::get('user_info_key_' . $uid)) return $userInfo;

        $userInfo = UserModel::getUserAndGroupsAndRolesAndAuthsByUid($where);

        if ($isCache) Cache::set('user_info_key_' . $uid, $userInfo->toArray(), $expire);
        return $userInfo;
    }

    /**
     * @param $uid
     * @param bool $isCache
     * @param int $expire
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十六日 17:14:37
     * @Description:获取用户已有的权限
     * @return array|bool
     */
    public function getUserAuths($uid, $isCache = false, $expire = 3600)
    {
        if (!$uid) return false;
        $userInfo = $this->getGroupsAndRolesAndAuthsByUid($uid, $isCache, $expire);
        if (empty($userInfo['groups'])) return ['code' => false, 'msg' => '没有分配组'];
        $auths = [];
        foreach ($userInfo['groups'] as $group) {
            foreach ($group['auths'] as $index => $auth) $auths[$auth['id']] = $auth;
        }
        if (empty($auths)) return ['code' => false, 'msg' => '没有分配权限'];
        return $auths;
    }

    /**
     * @param $uid
     * @param bool $isCache
     * @param int $expire
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十六日 17:43:58
     * @Description:检测权限
     * @return bool
     */
    public function checkAuths($uid, $isCache = false, $expire = 3600)
    {
        $ControllerAction = Request::controller(true) . '/' . Request::action(true);
        if (!$authsNames = Cache::get('auths_' . $uid)) {
            $auths = $this->getUserAuths($uid, $isCache, $expire);
            if (isset($auths['code'])) return $auths;
            $authsNames = array_column($auths, 'name', 'id');
            $authsNames = array_map('strtolower', $authsNames);
            if ($isCache) Cache::set('auths_' . $uid, $authsNames, $expire);
        }
        if (in_array($ControllerAction, $authsNames)) return true;
        return false;
    }

    /**
     * @param $uid
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:删除权限缓存
     * @return bool
     */
    public function rmAuthCache($uid)
    {
        Cache::rm('auths_' . $uid);
        return Cache::rm('user_info_key_' . $uid);
    }

    public function __call($name, $arguments)
    {
        return $this->$name(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.

        return static::$name(...$arguments);
    }

}