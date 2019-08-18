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
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

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

        $this->table = !empty($authUser = Config::get('auth.table.user')) ? $authUser : 'user';
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
        return $this->belongsToMany(\thinkAuth\Model\GroupModel::class, \UserGroupAccess::class, 'auth_group_id', 'uid');
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月12日 23:18:51
     * @Description:用户拥有的角色
     * @return \think\model\relation\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(\thinkAuth\Model\RoleModel::class, \UserRoleAccess::class, 'role_id', 'uid');
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
        $roles = $user->roles;
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
     * @param $uid
     * @param array $fields
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月14日 17:19:18
     * @Description:编辑用户获取用户信息及所属的权限组和角色
     * @return mixed
     */
    public static function editGetUserInfo($uid, $fields = array())
    {
        $user = self::get($uid);
        //获取组
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
        //获取角色
        $roles = $user->roles;

        if ($fields) {
            foreach ($roles as $key => $role) {
                $role = $role->toArray();
                foreach ($role as $field => $item) {
                    if (!in_array($field, $fields)) unset($roles[$key][$field]);
                }
            }
        }

        $user['groupIds'] = array_column($groups->toArray(), 'id');
        $user['roleIds'] = array_column($roles->toArray(), 'id');
        return $user;
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
        UserGroupAccess::where(['uid' => $uid])->delete();
        //删除角色关联关系
        UserRoleAccess::where(['uid' => $uid])->delete();
        return self::destroy($uid);
    }

    //=============================================================

    /**
     * @param string $userFields
     * @param string $groupField
     * @param string $roleFied
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十四日 10:11:23
     * @Description:获取用户列表及权限组和角色
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getUsersAndGroupsAndRoles($where = [], $userFields = '*', $groupField = '*', $roleFied = '*')
    {
        $map = [];
        $map[] = ['status', '=', 1];
        if (!empty($where)) $map = array_merge($map, $where);
        $usersAndGroupAndRoles = self::field($userFields)->with([
            'groups' => function ($query) use ($groupField) {
                $query->field($groupField);
            },
            'roles' => function ($query) use ($roleFied) {
                $query->field($roleFied);
            }
        ])->where($map)->select();
        return $usersAndGroupAndRoles;
    }

    /**
     * @param $where
     * @param string $userFields
     * @param string $groupField
     * @param string $roleFied
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月16日 15:13:15
     * @Description:根据用户ID获取用户的组和角色以及拥有权限规则
     * @return array|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getUserAndGroupsAndRolesAndAuthsByUid($where, $userFields = '*', $groupField = '*', $roleFied = '*')
    {
        $map = [];
        $map[] = ['status', '=', 1];
        if (!empty($where)) $map = array_merge($map, $where);

        $users = self::field($userFields)->with([
            'groups' => function ($query) use ($groupField) {
                $query->field($groupField)->with([
                    'auths' => function ($query) {
                        $query->field('*');
                    }
                ]);
            },
            'roles' => function ($query) use ($roleFied) {
                $query->field($roleFied);
            }
        ])->where($map)->findOrEmpty();
        return $users;
    }

    /**
     * @param string $userFields
     * @param string $groupField
     * @param string $roleFied
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获得所有的用户以及所属的权限组和角色
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getAddGroupsUsersToSelectOption($where = [], $userFields = '*', $groupField = '*', $roleFied = '*')
    {
        $usersAndGroupAndRoles = self::getUsersAndGroupsAndRoles($where = [], $userFields, $groupField, $roleFied);
        $addGroupSelectJson = [];
        $selectUserIds = Request::has('selected_user_ids') ? explode(',', trim(Request::get('selected_user_ids'), ',')) : [];

        $groupNane = $roleName = '';
        foreach ($usersAndGroupAndRoles as $index => $user) {
//            返回的格式[{"name":"北京","value":1,"selected":"","disabled":""}],
            //用户所属的组
            $groupNane = '';
            foreach ($user['groups'] as $i => $group) {
                $groupNane .= $group['title'] . ',';
            }
            //用户所属的角色
//            foreach ($user['roles'] as $i => $role) {
//                $groupNane .= $role['name'] . ',';
//            }
            $disabled = '';
            if ($user->getData('status') == 0) $disabled = 'disabled';
            //设置默认选中的用户
            $selected = '';
            if (in_array($user['id'], $selectUserIds)) $selected = 'selected';
            $addGroupSelectJson[] = ['name' => $user['user_name'], 'value' => $user['id'], 'selected' => $selected, 'disabled' => $disabled, 'group_name' => $groupNane];
        }
        return $addGroupSelectJson;
    }
}