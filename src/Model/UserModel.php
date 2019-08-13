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
 * @Description:用户信息模型
 */
class UserModel extends Model
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

        $this->table = !empty($authUser = Config::get('auth.table.auth_user')) ? $authUser : 'user';
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月12日 22:10:09
     * @Description:用户和用户组 多对多关联
     * @return \think\model\relation\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(\thinkAuth\Model\GroupModel::class, \AuthGroupAccess::class, 'auth_group_id', 'uid');
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月12日 23:18:51
     * @Description:用户拥有的角色
     * @return \think\model\relation\BelongsToMany
     */
    public function Roles()
    {
        return $this->belongsToMany(\thinkAuth\Model\UserRoleModel::class, \RoleAccess::class, 'role_id', 'uid');
    }

    /**
     * @param $uid
     * @param array $fields 获取想要的key
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十二日 22:39:19
     * @Description:获得用户所在的组
     * @return bool
     */
    public static function getUserGroups($uid, $fields = array())
    {
        if (!$uid) return false;
        $user = self::get($uid);
        $groups = $user->groups;
        //返回指定字段
        if ($fields) {
            foreach ($groups as $key => $group) {
                $group = $group->toArray();
                foreach ($group as $field => $item) {
                    if (!in_array($field, $fields)) unset($groups[$key][$field]);
                }
            }
        }
        return $groups;
    }

    /**
     * @param $uid
     * @param array $fields 获取想要的key
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019-08-12 23:20:28
     * @Description:获得用户拥有的角色
     * @return bool
     */
    public static function getUserRoles($uid, $fields = array())
    {
        if (!$uid) return false;
        $user = self::get($uid);
        $roles = $user->Roles;
        //返回指定字段
        if ($fields) {
            foreach ($roles as $key => $role) {
                $role = $role->toArray();
                foreach ($role as $field => $item) {
                    if (!in_array($field, $fields)) unset($roles[$key][$field]);
                }
            }
        }
        return $roles;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获取用户列表
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUsersByPage()
    {
        $page = Request::get('page', 1, 'intval');
        $limit = Request::get('limit', 30, 'intval');
        $map = [];
        if (Request::has('search')) {
            $map[] = ['user_name', 'like', Request::get('search') . '%'];
            $map[] = ['email', 'like', Request::get('search') . '%'];
        }
        return $this->field('*')->page($page, $limit)->whereOr($map)->order('id', 'desc')->select();
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:44:04
     * @Description:获取用户数量 用于layui分页
     * @return float|string
     */
    public function getUsersCount()
    {
        $map = [];
        if (Request::has('search')) {
            $map[] = ['user_name', 'like', Request::get('search') . '%'];
            $map[] = ['email', 'like', Request::get('search') . '%'];
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
        $data = Request::post();
        $user = self::create($data);
        //分配组
        if (!empty($data['group_id'])) {
            $user->groups()->saveAll(explode(',', $data['group_id']));
        }
        //分配角色
        if (!empty($data['role_id'])) {
            $user->Roles()->saveAll(explode(',', $data['role_id']));
        }

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
//        array(11) {
//        ["group_id"] => string(3) "1,5"
//        ["have_group_ids"] => string(8) "1,2,3,4,"
//        ["role_id"] => string(7) "8,9,2,4"
//        ["have_role_ids"] => string(6) "1,8,9,"
//        ["user_name"] => string(18) "重置表单测试"
//        ["email"] => string(13) "123456@qq.com"
//        ["status"] => string(2) "on"
//        ["sex"] => string(1) "1"
//        ["id"] => string(2) "21"
//        ["del_group_ids"] => string(9) "4,3,3,2,4"
//        ["del_role_ids"] => string(5) "9,8,1"
//}
        $editData = Request::post();
        $user = self::update($editData);
        //删除已有的角权限组
        if (!empty($editData['have_group_ids'])) {
            $user->groups()->detach(explode(',', $editData['have_group_ids']));
        }
        //删除已有的角色
        if (!empty($editData['have_role_ids'])) {
            $user->roles()->detach(explode(',', $editData['have_role_ids']));
        }

        //重新分配组
        if (!empty($editData['group_id'])) {
            $user->groups()->saveAll(explode(',', $editData['group_id']));
        }
        //重新分配角色
        if (!empty($editData['role_id'])) {
            $user->Roles()->saveAll(explode(',', $editData['role_id']));
        }
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
        $uid = Request::post('id');
        //删除权限组关联关系
        AuthGroupAccess::where(['uid'=> $uid])->delete();
        //删除角色关联关系
        RoleAccess::where(['uid'=> $uid])->delete();
        return self::destroy($uid);
    }
}